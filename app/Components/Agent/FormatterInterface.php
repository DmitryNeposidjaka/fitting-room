<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 18:40
 */

namespace App\Components\Agent;


interface FormatterInterface
{
    public static function products($data) : array ;
    public static function categories($data) : array ;
}