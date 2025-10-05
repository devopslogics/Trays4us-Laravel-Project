<?php

namespace App\Exports;

use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExportExcel implements FromCollection, WithHeadings , WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->leftJoin('product_style as style', 'style.id', '=', 'products.style_id')
            ->leftJoin('countries', 'countries.id', '=', 'products.country_id')
            ->leftJoin('states', 'states.id', '=', 'products.state_id')
            ->select('products.product_name','products.product_description','style.style_name','countries.country_name','states.state_name','products.id as pid','products.product_customizable','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.first_name','artist.last_name','artist.last_name','artist.display_name' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->orderBy('products.id', 'desc')
            ->get();

        $result = collect();
        foreach ($products as $product) {

            if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
                $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($product->pt_sub_id);

            // Get minimam order quantity and case pack from customizable_type_relation table
            $moq_case_pack = array();
            if(isset($product->product_customizable) AND isset($product->pt_sub_id))
                $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product->pt_sub_id);


            $product_detail = Products::find($product->pid);
            $tag_names = $product_detail->tags->pluck('tag_name');
            $tags = $tag_names->implode(', ');

            $row = [
                'Product Name' => html_entity_decode($product->product_name),
                'Product SKU' => $product->product_sku,
                'Product type' => $getProductTypeDetail->child->type_name ?? '',
                'Artist (Display Name)' => $product->display_name ?? $product->first_name.' '.$product->last_name,
                'MoQ' => (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity  : 1,
                'Case Pack' => (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack  : 1,
                'Style' => $product->style_name ?? '',
                'Badge' => $product->badge ?? '',
                'Tags' => $tags ?? '',
                'Country' => $product->country_name ?? '',
                'State' => $product->state_name ?? '',
                'Description' => $product->product_description ?? '',
                'Wholesale price' => $product->price ?? '',
                'Main image (URL)' =>  url('uploads/products/'.$product->feature_image) ?? '',
                // Add other fields as needed
            ];

            // Get product images and push them to array
            $product_images = ProductImages::where('product_id', $product->pid)->get()->toarray();
            $counter = 2;
            $row2 = array();
            foreach($product_images as $product_image) {
                if($product->feature_image != $product_image['image_name']){
                    $row2['Image ' . $counter . ' (URL)'] =  url('uploads/products/'.$product_image['image_name']);
                    $counter++;
                }
            }

            $result->push($row + $row2);
        }

        return $result;

    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                //echo "here";exit;
                /** @var Worksheet $sheet */
                foreach ($event->sheet->getColumnIterator('H') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if ($cell->getValue() != "" && str_contains($cell->getValue(), '://')) {
                            $cell->setHyperlink(new Hyperlink($cell->getValue(), 'Read'));

                            // Upd: Link styling added
                            $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                'font' => [
                                    'color' => ['rgb' => '0000FF'],
                                    'underline' => 'single'
                                ]
                            ]);
                        }
                    }
                }
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Product name',
            'SKU',
            'Product type',
            'Artist (Display Name)',
            'MoQ',
            'Case Pack',
            'Style',
            'Badge',
            'Tags',
            'Country',
            'State',
            'Description',
            'Wholesale price',
            'Main image (URL)',
            'Image 2 (URL)',
            'Image 3 (URL)',
            'Image 4 (URL)',
            'Image 5 (URL)',
            'Image 6 (URL)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

}
