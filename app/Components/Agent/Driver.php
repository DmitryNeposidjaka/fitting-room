<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 18:43
 */

namespace App\Components\Agent;


use App\models\Customer;
use App\models\Order;
use App\models\UserRegistration;

class Driver implements DriverInterface
{
    public $server;
    public $mirrors = [];
    /**
     * @var Client
     */
    public $client;
    /**
     * @var Formatter
     */
    public $formatter;

    public function __construct(array $options = [])
    {
        if(empty($options['client'])) throw new \ErrorException('Client must be Set!');
        if(empty($options['formatter'])) throw new \ErrorException('Formatter must be Set!');
        if(empty($options['server'])) throw new \ErrorException('Server must be Set!');
        if(isset($options['mirrors'])) $this->mirrors = $options['mirrors'];
        $this->server = $options['server'];
        $this->mirrors = $options['mirrors'];
        $this->client = new $options['client'](['baseUrl' => $this->server, 'timeout' => 5, 'mirrors' => $this->mirrors]);
        $this->formatter = new$options['formatter'];
        if(!($this->client instanceof ClientInterface)) throw new \ErrorException('Client must be an instance of ClientInterface!');
        if(!($this->formatter instanceof FormatterInterface)) throw new \ErrorException('Formatter must be an instance of FormatterInterface!');
    }

    public function getServer()
    {
        return $this->server;
    }

    public function changeServer($method)
    {
       if(is_null(key($this->mirrors))) return null;
       $this->client->setBaseUrl(current($this->mirrors));;
       next($this->mirrors);
       return $this->$method();
    }


    public function checkStatus($status)
    {
        return true;        //  TODO check status function
    }

    public function registration(UserRegistration $model)
    {
        return $this->formatter::registration($this->client->registration($model));
    }

    public function auth($login, $pass)
    {
        return $this->formatter::auth($this->client->auth($login, $pass));
    }

    public function authSoc($provider, $id)
    {
        return $this->formatter::auth($this->client->authSoc($provider, $id));
    }

    public function getProducts()
    {
        $response = $this->client->getProducts();

        if(!$this->checkStatus($response->getStatusCode())){
            $response = $this->changeServer(__FUNCTION__);
        }

        return $this->formatter::products($response->getBody());
    }

    public function getCategories()
    {
        $response = $this->client->getCategories();

        if(!$this->checkStatus($response->getStatusCode())){
            $response = $this->changeServer(__FUNCTION__);
        }

        return $this->formatter::categories($response->getBody());
    }

    public function getCustomerData($customer_token)
    {
        return $this->formatter::getCustomerData($this->client->getCustomerData($customer_token));
    }

    public function updateCustomerData($customer_token, Customer $model)
    {
        return $this->formatter::updateCustomerData($this->client->updateCustomerData($customer_token, $model));
    }

    public function getCustomerOrders($customer_token)
    {
        return $this->client->getCustomerOrders($customer_token);
    }

    public function getCartToken($customer_token)
    {
        return $this->formatter::cartToken($this->client->getCartToken($customer_token));
    }

    public function getCart($cart_token, $customer_token)
    {
        return $this->formatter::cart($this->client->getCart($cart_token, $customer_token));
    }

    public function addOrder($cart_token, $customer_token, Order $model)
    {
        return $this->client->addOrder($cart_token, $customer_token, $model);
    }

    public function removeOrder($cart_token, $customer_token, Order $model)
    {
        return $this->formatter::removeOrder($this->client->removeOrder($cart_token, $customer_token, $model));
    }

    public function processingOrder($cart_token = null, $customer_token, Customer $model = null)
    {
        return $this->formatter::processingOrder($this->client->processingOrder($cart_token, $customer_token, $model));
    }
}