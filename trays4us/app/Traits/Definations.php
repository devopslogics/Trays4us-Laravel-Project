<?php

namespace App\Traits;

use App\Models\User;
use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

trait Definations
{
    public static function getOrderStatusClass($status)
    {
        $statusClass =  'submitted';
        $statusVal =  'Submitted';

        if($status == 1) {
            $statusClass =  'submitted';
            $statusVal =  'Submitted';
        }

        if($status == 2) {
            $statusClass = 'added_to_production';
            $statusVal =  'Added to production';
        }

        if($status == 3) {
            $statusClass =  'produced';
            $statusVal =  'Produced';
        }

        if($status == 4) {
            $statusClass =  'arriving_to_warehouse';
            $statusVal =  'Arriving to warehouse';
        }

        if($status == 5) {
            $statusClass =  'shipped';
            $statusVal =  'Shipped';
        }

        if($status == 6) {
            $statusClass =  'cancel';
            $statusVal =  'Cancelled';
        }

        return array($statusClass, $statusVal);

    }

    public static function getProductTypeDetail($child_id)
    {

        $parent_detail = '';
        if ($child_id > 0) {
            $child_type_detail = ProductType::find($child_id);
            if($child_type_detail) {
                $parent_detail = ProductType::select('*')
                    ->where('id', $child_type_detail->parent_id)
                    ->first();
                $parent_detail->child = $child_type_detail;
            }
            return $parent_detail;
        }
        return $parent_detail;
    }

    public static function getCustomProductHtmlClass($product_sku)
    {
        if (strpos($product_sku, 'R157') !== false) {
            return "rounded_image";
        }
        return "rectangle_image";
    }

    public static function generateSlugLastString($parent_product_type, $sub_product_type) {
        $slug_mappings = [
            'Coasters' => 'coasters',
            'Small' => 'small',
            'Medium' => 'medium',
            'Large' => 'large',
            'Round' => 'round'
        ];

        foreach ($slug_mappings as $substring => $slug) {
            if ((isset($parent_product_type) && str_contains($parent_product_type, $substring)) ||
                (isset($sub_product_type) && str_contains($sub_product_type, $substring))) {
                return $slug;
            }
        }

        return ''; // Default case if no match found
    }

    public static function generateMetaTitle($input_string, $limit = 160) {
        if (!empty($input_string)) {
            // Remove all characters except letters, numbers, and spaces
            $clean_string = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags($input_string));

            // Trim extra spaces and limit the length of the title
            $clean_string = trim($clean_string);
            $clean_string = substr($clean_string, 0, $limit); // Adjust the length as needed

            // Convert the title to lowercase
            $meta_title = strtolower($clean_string);

            return $meta_title;
        }
    }

    public function generateProductStructuredData($product,$page_title = '', $pageDescription = '') {


        $productData = [
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "name" => ucwords($page_title) ?? 'Product Name',
            "image" => url('uploads/products/large-'.$product->feature_image),
            "description" => ucwords($pageDescription) ?: 'Create Your Own Custom Tray',
            "brand" => [
                "@type" => "Brand",
                "name" => ucwords($product->display_name) ?? 'Trays4us'
            ],
            "sku" => $product->product_sku ?? '000000',
            "offers" => [
                "@type" => "Offer",
                "url" => url()->current(),
                "itemCondition" => "https://schema.org/NewCondition"
            ],
            "manufacturer" => "Trays4Us",
            "material" => "Wood",
            "breadcrumb" => [
                "@type" => "BreadcrumbList",
                "itemListElement" => [
                    [
                        "@type" => "ListItem",
                        "position" => 1,
                        "name" => "Home",
                        "item" => route('home')
                    ],
                    [
                        "@type" => "ListItem",
                        "position" => 2,
                        "name" => "Catalog",
                        "item" => route('frontend.products')
                    ],
                    [
                        "@type" => "ListItem",
                        "position" => 3,
                        "name" => $product->product_name ?? '',
                        "item" => url()->current()
                    ]
                ]
            ]
        ];

        $jsonData = json_encode($productData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return $jsonData;
        /*

        $productData = [
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "name" => ucwords($page_title) ?? 'Product Name',
            "image" => url('uploads/products/large-'.$product->feature_image),
            "description" => ucwords($pageDescription) ?: 'Create Your Own Custom Tray',
            "brand" => [
                "@type" => "Brand",
                "name" => ucwords($product->display_name) ?? 'Trays4us'
            ],
            "sku" => $product->product_sku ?? '000000',
            "offers" => [
                "@type" => "Offer",
                "url" => url()->current(),
                // "priceCurrency" => "USD",
                // "availability" => "https://schema.org/InStock",
                "itemCondition" => "https://schema.org/NewCondition",
            ],
            "manufacturer" => "Trays4Us",
            "material" => "Wood",
        ];

        $breadcrumbData = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => route('home') // Assuming you are using Laravel's route helper function
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "Catalog",
                    "item" => route('shop-in-wholesale') // Assuming you are using Laravel's route helper function
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => $product->product_name ?? '',
                    "item" => url()->current() // Assuming you are using Laravel's route helper function
                ]
            ]
        ];

        // Encode each JSON object separately
        $productJson = json_encode($productData );
        $breadcrumbJson = json_encode($breadcrumbData);

        // Return the JSON encoded strings as needed
        return $productJson .','. $breadcrumbJson; */
    }

    public static function remove_background_from_image($destinationPath,$file_name) {

        $inputImagePath = $destinationPath . $file_name;
        $outputImagePath = $destinationPath . $file_name;

        $backgroundColor = [255, 255, 255];


        $image = Image::make($inputImagePath);

        $newImage = Image::canvas($image->width(), $image->height(), [0, 0, 0, 0]);


        $image->encode('png'); // Ensure image is in PNG format
        $imgData = $image->getEncoded(); // Get the raw image data

        $inputResource = imagecreatefromstring($imgData);
        $width = imagesx($inputResource);
        $height = imagesy($inputResource);

        $outputResource = imagecreatetruecolor($width, $height);
        imagesavealpha($outputResource, true);
        $transparency = imagecolorallocatealpha($outputResource, 0, 0, 0, 127);
        imagefill($outputResource, 0, 0, $transparency);

        // Loop through each pixel in the input image
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $color = imagecolorat($inputResource, $x, $y);
                $alpha = ($color >> 24) & 0xFF;
                $rgb = imagecolorsforindex($inputResource, $color);
                if ($rgb['red'] === $backgroundColor[0] && $rgb['green'] === $backgroundColor[1] && $rgb['blue'] === $backgroundColor[2]) {
                    $alpha = 127; // Set full transparency
                }
                $newColor = imagecolorallocatealpha($outputResource, $rgb['red'], $rgb['green'], $rgb['blue'], $alpha);
                imagesetpixel($outputResource, $x, $y, $newColor);
            }
        }

        imagepng($outputResource, $outputImagePath);
        imagedestroy($inputResource);
        imagedestroy($outputResource);
    }

}
