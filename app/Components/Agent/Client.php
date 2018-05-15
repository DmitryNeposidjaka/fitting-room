<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 16:54
 */

namespace App\Components\Agent;


use App\models\UserRegistration;

class Client implements ClientInterface
{
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

    public function registration(UserRegistration $model)
    {
        $response = $this->client->request('POST', array_shift($this->mirrors)."customer/register", [
            'headers' => [
                'X-Security-Token' => 'test',
            ],
            'form_params' => [
                'email' => $model->email,
                'name' => $model->name,
                'phone' => $model->phone,
                'password' => $model->password,
            ],
        ]);
        return $response;
    }

    public function auth($login, $pass)
    {
        $response = $this->client->request('POST', array_shift($this->mirrors)."auth", [
            'headers' => [
                'X-Security-Token' => 'test',
            ],
            'json' => [
                'type' => 'login',
                'email' => $login,
                'password' => $pass,
            ],
        ]);
        return $response;
    }

    public function authSoc($provider, $id)
    {
        $response = $this->client->request('POST', "{$this->baseUrl}auth", [
            ['json' => [
                'type' => 'social',
                'provider' => $provider,
                'user_id' => $id,
            ]]
        ]);
        return $response;
    }

    public function getProducts()
    {
        $response = $this->client->request('GET', "{$this->baseUrl}export/products", [
            'query' => ['api_auth_token' => 'test']
        ]);
        return $response;
    }

    public function getCategories()
    {
        $response = $this->client->request('GET', "{$this->baseUrl}export/categories", [
            'query' => ['api_auth_token' => 'test']
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