<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 18:39
 */

namespace App\Components\Agent;


interface ClientInterface
{
    public function getProducts();
    public function auth($login, $pass);
    public function getCategories();
    public function getHttpClient();
    public function setBaseUrl($url);
    public function setMirrors(array $data);
}