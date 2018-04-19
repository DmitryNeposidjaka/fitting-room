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
        $categories = $instance->getCategories();

        $result = [];
        foreach ($products as $product){
            foreach ($product->categories as $category){
                $cat_id = $category->id;

                $cat = current(array_filter($categories, function ($v) use($cat_id){
                    return $v->id === $cat_id;
                }));

                $result[$cat->title][] = $product;
            }

        }
        var_dump($result);
        var_dump($products);
    }
}