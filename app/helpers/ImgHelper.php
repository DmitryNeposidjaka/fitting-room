<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 19.04.18
 * Time: 22:09
 */

namespace App\helpers;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

class ImgHelper
{
    private static $product_path = "uploads/products/";

    /**
     * @param  $path
     * @param string $name
     * @param int $width
     * @param int $quality
     * @return null|string
     */
    public static function saveProductPhoto( $path, string $name, $width = 500, $quality = 60){
        try{
            $img = Image::make($path)->widen($width)->save(PUBLIC_DIR.'/'.self::$product_path.$name, $quality);
            unset($img);
        }catch (\Exception $e){
            Log::info(sprintf("\n\nSeve product photo fail!\n%s", self::getProviderImgPath($path)));
            throw $e;
        }
        self::getProductPhotoPath($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function productPhotoExists(string $name){
        return file_exists(self::$product_path.$name);
    }

    /**
     * @param string $name
     * @return null|string
     */
    public static function getProductPhotoPath(string $name){
        if(file_exists(PUBLIC_DIR.'/'.self::$product_path.$name)){
            return self::$product_path.$name;
        }else{
            return null;
        }
    }

    public static function getProviderImgPath($path){
        return $path;
    }
}