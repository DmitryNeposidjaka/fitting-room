<?php

$router->group(['namespace' => 'api', 'middleware' => ['cors']], function () use($router){

    $router->post('/auth', 'AuthController@auth');
    $router->post('/auth-soc', 'AuthController@authSoc');
    $router->post('/registration', 'AuthController@registration');
/*    $router->get('/auth', function (){
        return view('auth', ['result' => null]);
    });
    $router->get('/registration', function (){
        return view('registration', ['result' => null]);
    });*/
});

$router->group(['namespace' => 'api', 'prefix' => 'api', 'middleware' => 'cors'], function () use($router){
    $router->get('/products', 'BaseController@products');
    $router->get('/test', 'BaseController@test');
    $router->get('/customer/data', 'CustomerController@getData');
    $router->patch('/customer/data', 'CustomerController@updateData');
    $router->get('/customer/orders', 'CustomerController@getOrders');
    $router->get('/cart/token', 'CartController@getToken');
    $router->get('/cart', 'CartController@getCart');
    $router->post('/cart/processing', 'CartController@toProcess');
    $router->post('/order', 'CartController@add');
    $router->delete('/order', 'CartController@delete');
    $router->get('/catalog', 'CustomerController@catalog');
    $router->post('/catalog', 'CustomerController@addCatalog');
    $router->get('/password/email', 'CustomerController@email');
});

