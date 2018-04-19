<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 14:03
 */

namespace App\Http\Controllers\api;


use App\Components\Agent\Agent;
use App\Http\Controllers\Controller;
use function PHPSTORM_META\map;


class BaseController extends Controller
{
    public function __construct()
    {
        //
    }


    public function test(){
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
                $result[$conf_cats[$cat_id]][] = $result_product;
            }

        }
        echo json_encode($result);
    //    var_dump($products);
    }
}