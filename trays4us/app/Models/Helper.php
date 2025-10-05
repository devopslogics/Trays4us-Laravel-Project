<?php

/**
 * Class Helper
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Models;
use App\Models\ProductType;
use Intervention\Image\Facades\Image;
use File;

use Illuminate\Database\Eloquent\Model;


class Helper extends Model
{
    public static function get_sub_type_by_parent_id($pid)
    {
        $sub_types = array();
        if ($pid) {
            $sub_types = ProductType::select('*')
                ->where("status", "=", 1)
                ->where("parent_id", "=", $pid)
                ->orderBY('id', 'DESC')
                ->get();
            return $sub_types;
        }
        return $sub_types;
    }

    public static function uploadImage($path, $image, $file_name = "", $image_size = array())
    {

        if (!empty($image)) {
            $file_original_name = $image->getClientOriginalName();
            $file_original_name = !empty($file_name) ? $file_name : $file_original_name;

            $upload_img = Image::make($image);
            $upload_img->fit(
                100,
                100,
                function ($constraint) {
                    $constraint->upsize();
                }
            );
            $upload_img->save($path . '/medium-' . $file_original_name);
        }
    }

    public static function uploadTempImageWithSize($path, $image, $file_name = "", $image_size = array())
    {
        $json = array();
        if (!empty($image)) {
            $file_original_name = $image->getClientOriginalName();
            $parts = explode('.', $file_original_name);
            $extension = end($parts);

                $file_original_name = !empty($file_name) ? $file_name : $file_original_name;
                if (!empty($image_size)) {
                    foreach ($image_size as $key => $size) {
                        $small_img = Image::make($image);
                        $small_img->fit(
                            $size['width'],
                            $size['height'],
                            function ($constraint) {
                                $constraint->upsize();
                            }
                        );
                        //echo $path . $key . '-' . $file_original_name.'-------';
                        $small_img->save($path . $key . '-' . $file_original_name);
                    }
                }
                //exit;
                // save original image size
                $img = Image::make($image);
                $img->save($path . $file_original_name);
                $json['message'] = 'Image uploaded';
                $json['type'] = 'success';
                return $json;
            } else {
                $json['message'] = trans('lang.img_jpg_png');
                $json['type'] = 'error';
                return $json;
            }
    }

    public static function filter_filename($name) {
        // remove illegal file system characters
        $name = str_replace(
            array_merge(
                array_map('chr', range(0, 31)),
                array('<', '>', ':', '"', '/', '\\', '|', '?', '*')
            ),
            '',
            $name
        );

        // replace spaces with dashes
        $name = str_replace(' ', '-', $name);

        // maximise filename length to 255 bytes
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $name = mb_strcut(
                pathinfo($name, PATHINFO_FILENAME),
                0,
                255 - ($ext ? strlen($ext) + 1 : 0),
                mb_detect_encoding($name)
            ) . ($ext ? '.' . $ext : '');

        return $name;
    }

    // Get minimum order Quantity and case pack, $ptid means product_type table id while , $dt_id means design table id
    public static function get_moq_case_pack($dt_id, $ptid)
    {
        $moq_case_pack = ProductType::select('ctr.id as cid','ctr.minimum_order_quantity','product_type.case_pack')
            ->leftJoin('customizable_type_relation as ctr', 'ctr.product_type_id', '=', 'product_type.id')
            ->where("ctr.product_customizable_id", "=", $dt_id)
            ->where("ctr.product_type_id", "=", $ptid )
            ->first();
        return $moq_case_pack;
    }

    public static function imageCreateCorners($sourceImageFile, $radius) {

        $image = new \Imagick($sourceImageFile);

        $image->roundCorners($radius, $radius);

        $image->setImageFormat("png");

        $image->writeImage($sourceImageFile);

        $image->clear();
        $image->destroy();
    }

}
