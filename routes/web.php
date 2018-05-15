<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use GuzzleHttp\Client;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['namespace' => 'api', 'prefix' => 'api', 'middleware' => 'cors'], function () use($router){
    $router->get('/products', 'BaseController@products');
    $router->get('/test', 'BaseController@test');
});

$router->group(['namespace' => 'api', 'middleware' => 'cors'], function () use($router){

    $router->post('/auth', 'AuthController@auth');
    $router->post('/registration', 'AuthController@registration');
    $router->get('/auth', function (){
        return view('auth', ['result' => null]);
    });
    $router->get('/registration', function (){
        return view('registration', ['result' => null]);
    });
});