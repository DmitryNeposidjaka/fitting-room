<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 16:54
 */

namespace App\Components\Agent;


class Client implements ClientInterface
{
    public $baseUrl;
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(array $options = [])
    {
        $this->client = new \GuzzleHttp\Client($options);
        $this->setBaseUrl($options['baseUrl']);
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




}