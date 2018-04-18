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

        var_dump($products);
    }
}