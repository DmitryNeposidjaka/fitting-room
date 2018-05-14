<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 18:41
 */

namespace App\Components\Agent;


interface DriverInterface
{
    public function getServer();
    public function auth($login, $pass);
    public function getProducts() ;
    public function getCategories() ;
}