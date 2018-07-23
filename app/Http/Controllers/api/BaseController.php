<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 14:03
 */

namespace App\Http\Controllers\api;


use App\Components\Agent\Agent;
use App\helpers\ImgHelper;
use App\Http\Controllers\Controller;
use function PHPSTORM_META\map;



class BaseController extends Controller
{
    public function __construct()
    {
        //
    }

    private function measurements($data){
        $result = [];
        foreach ($data as $measurement){
            if(!isset($measurement->pivot)) continue;
            $pivot = $measurement->pivot;
            $title = $measurement->title;
            $result[$pivot->size_id][$title] = $pivot->value;
            if(!empty($pivot->growth_id)) $result[$pivot->size_id]['growth_id'] = $pivot->growth_id;
        }

        return $result;
    }
    public function products(){
        /**
         * @var $instance Agent
         */
        $instance = app(Agent::class);
        $products = $instance->getProducts();
        $conf_cats = config('api.categories');

        $result = [];
        foreach ($products as $product){
            foreach ($product->categories as $category){
                $cat_id = $category->id;
                if (!isset($conf_cats[$cat_id])) continue;
                $result_product = $product;
                unset($result_product->categories);

                foreach ($result_product->images as $k => $image){
                    if(ImgHelper::productPhotoExists(basename($image))){
                        $result_product->images[$k] = url(ImgHelper::getProductPhotoPath(basename($image)));
                    }else{

                        $base64Image = (base64_encode($image))? $image : base64_decode($image);
                        $result_product->images[$k] = url(ImgHelper::saveProductPhoto($base64Image, basename($image)));
                    }
                }
                $result_product->measurements = $this->measurements($result_product->measurements);
                $result[$conf_cats[$cat_id]][] = $result_product;
            }

        }
        return json_encode($result);
    }

    public function test(){
        var_dump(basename( url('/uploads/img.jpg')));
    }
}