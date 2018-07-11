<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 18:28
 */

namespace App\Components\Agent;


use GuzzleHttp\Psr7\Response;

class Formatter implements FormatterInterface
{
    public static function products($data): array
    {
        return json_decode($data);
    }

    public static function registration(Response $data)
    {
        switch ($data->getStatusCode()){
            case 201:
                $response = [
                    'message' => 'Created',
                    'data'    => json_decode($data->getBody()->getContents())
                ];
                break;
            case 409:
                $response = [
                    'message' => 'User already Exist!',
                    'data'    => json_decode($data->getBody()->getContents())
                ];
                break;
            case 500:
                $response = [
                    'message' => 'some Error!',
                    'data'    => [
                        'status' => $data->getStatusCode(),
                        'body'   => $data->getBody()->getContents()
                    ]
                ];
                break;
            default: $response = [];
        }

        return $response;
    }

    public static function auth(Response $data): array
    {
        switch ($data->getStatusCode()){
            case 200:
                $response = [
                    'message' => 'Authorized',
                    'data'    => json_decode($data->getBody()->getContents())
                ];
                break;
            case 409:
                $response = [
                    'message' => 'User already Exist!',
                    'data'    => json_decode($data->getBody()->getContents())
                ];
                break;
            case 500:
                $response = [
                    'message' => 'some Error!',
                    'data'    => [
                        'status' => $data->getStatusCode(),
                        'body'   => $data->getBody()->getContents()
                    ]
                ];
                break;
            default: $response = [];
        }

        return $response;
    }

    public static function categories($data): array
    {
        return json_decode($data);
    }

    public static function cartToken(Response $data){
        $result = null;
        if($data->getStatusCode() == 200){
            $result = $data->getBody()->getContents();
        }
        return $result;
    }

    public static function cart(Response $data){
        $result = null;
        if($data->getStatusCode() == 200){
            $result = $data->getBody()->getContents();
        }
        return $result;
    }

    public static function addOrder(Response $data){
        $result = null;
        if($data->getStatusCode() == 200){
            $result = $data->getBody()->getContents();
        }
        return $result;
    }

    public static function removeOrder(Response $data){
        $result = null;
        if($data->getStatusCode() == 200){
            $result = $data->getBody()->getContents();
        }
        return $result;
    }
    public static function processingOrder(Response $data){
        $result = null;
        if($data->getStatusCode() == 200){
            $result = $data->getBody()->getContents();
        }
        return $result;
    }
}