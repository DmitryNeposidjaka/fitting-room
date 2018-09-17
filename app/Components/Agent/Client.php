<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 16:54
 */

namespace App\Components\Agent;


use App\models\Customer;
use App\models\Order;
use App\models\UserRegistration;

class Client implements ClientInterface
{
    const SECURITY_TOKEN = 'test';

    public $baseUrl;
    public $mirrors;
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(array $options = [])
    {
        $this->client = new \GuzzleHttp\Client($options);
        $this->setBaseUrl($options['baseUrl']);
        $this->setMirrors($options['mirrors']);
    }

    /**
     * @param UserRegistration $model
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function registration(UserRegistration $model)
    {
        $options = [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
            ],
            'form_params' => [
                'email' => $model->email,
                'name' => $model->name,
                'phone' => $model->phone,
                'password' => $model->password,
            ],
            'http_errors' => false
        ];
        $response = $this->client->request('POST', array_shift($this->mirrors)."customer/register", $options);
        return $response;
    }

    /**
     * @param $login
     * @param $pass
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function auth($login, $pass)
    {
        $response = $this->client->request('POST', array_shift($this->mirrors)."customer/auth", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
            ],
            'json' => [
                'type' => 'login',
                'email' => $login,
                'password' => $pass,
            ],
        ]);
        return $response;
    }

    /**
     * @param $provider
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function authSoc($provider, $id)
    {
        $response = $this->client->request('POST', array_shift($this->mirrors)."customer/auth", [
            'headers' => [
                'X-Security-Token' => self::SECURITY_TOKEN,
            ],
            'json' => [
                'type' => 'social',
                'provider' => $provider,
                'user_id' => $id,
            ]
        ]);
        return $response;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getProducts()
    {
        $response = $this->client->request('GET', "{$this->baseUrl}export/products", [
            'query' => ['api_auth_token' => self::SECURITY_TOKEN]
        ]);
        return $response;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getCategories()
    {
        $response = $this->client->request('GET', "{$this->baseUrl}export/categories", [
            'query' => ['api_auth_token' => self::SECURITY_TOKEN]
        ]);
        return $response;
    }

    /**
     * @param $customer_token
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getCustomerData($customer_token){
        $response = $this->client->request('GET', array_shift($this->mirrors)."customer/info", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-customer-token' => $customer_token,
            ],
        ]);
        return $response;
    }

    /**
     * @param $customer_token
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getCustomerOrders($customer_token){
        $response = $this->client->request('GET', array_shift($this->mirrors)."customer/orders", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-customer-token' => $customer_token,
            ],
        ]);
        return $response;
    }

    /**
     * @param $customer_token
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getCartToken($customer_token){
        $response = $this->client->request('GET', array_shift($this->mirrors)."cart/token", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-customer-token' => $customer_token,
            ],
        ]);
        return $response;
    }

    /**
     * @param $cart_token
     * @param $customer_token
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getCart($cart_token, $customer_token){
        $response = $this->client->request('GET', array_shift($this->mirrors)."cart", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-customer-token' => $customer_token,
                'x-cart-token' => $cart_token,
            ],
        ]);
        return $response;
    }

    public function getCatalog($cart_token){
        $response = $this->client->request('GET', array_shift($this->mirrors)."catalog/viewed", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-cart-token' => $cart_token,
            ],
        ]);
        return $response;
    }


    /**
     * @param $cart_token
     * @param $customer_token
     * @param Order $model
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function addOrder($cart_token, $customer_token, Order $model){
        $response = $this->client->request('POST', array_shift($this->mirrors)."cart", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-cart-token' => $cart_token,
                'x-customer-token' => $customer_token,
            ],
            'json' => [
                'product_id' => $model->product_id,  //  ID товара
                'growth_id' => $model->growth_id,    //  ID роста
                'size_id' => $model->size_id,     //  ID размера
                'qty' => $model->amount,      //  Количество
            ],
        ]);
        return $response;
    }

    /**
     * @param $cart_token
     * @param $customer_token
     * @param Order $model
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function removeOrder($cart_token, $customer_token, Order $model){
        $response = $this->client->request('DELETE', array_shift($this->mirrors)."cart/remove-item", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-cart-token' => $cart_token,
                'x-customer-token' => $customer_token,
            ],
            'json' => [
                'product_id' => $model->product_id,
                'growth_id' => $model->growth_id,
                'size_id' => $model->size_id,
                'qty' => $model->amount,
            ],
        ]);
        return $response;
    }

    /**
     * @param null $cart_token
     * @param $customer_token
     * @param Customer|null $model
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function processingOrder($cart_token = null, $customer_token, Customer $model = null){
        $customer_data = [];
        $headers = [];
        $headers['x-security-token'] = self::SECURITY_TOKEN;
        $headers['x-cart-token'] = $cart_token;
        $data = ['headers' => $headers];

        if(!is_null($model)){
            $headers['x-customer-token'] = $customer_token;
        }

        if(!is_null($model)){
            $customer_data['name'] = $model->name;
            $customer_data['email'] = $model->email;
            $customer_data['phone'] = $model->phone;
            $data = array_merge($data, ['form_params' => $customer_data]);
        }
        $response = $this->client->request('POST', array_shift($this->mirrors)."cart/order", $data);
        return $response;
    }

    public function updateCustomerData($customer_token, Customer $model){
        $response = $this->client->request('POST', array_shift($this->mirrors)."customer/edit", [
            'headers' => [
                'x-security-token' => self::SECURITY_TOKEN,
                'x-customer-token' => $customer_token,
            ],
            'json' => array_filter( $model->toArray()),
            'http_errors' => false
        ]);

        return $response;
    }

    public function getHttpClient()
    {
        return $this->client;
    }

    public function setBaseUrl($url){
        $this->baseUrl = $url;
    }

    public function setMirrors(array $data)
    {
        $this->mirrors = $data;
    }


}