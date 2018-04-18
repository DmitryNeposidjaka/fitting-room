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

$router->get('/test', function () use ($router) {
    $client = new Client([
        'base_uri' => 'http://nano8.net',
        'timeout'  => 2.0,
    ]);
    $response = $client->request('GET', '/primerka/index.php', ['query' => ['module' => 'Products', 'category' => 'all']]);
    echo '<pre>';
    echo $response->getBody();
});

$router->group(['namespace' => 'api', 'prefix' => 'api'], function () use($router){
    $router->get('/test', 'BaseController@test');
});