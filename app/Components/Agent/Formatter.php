<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 18:28
 */

namespace App\Components\Agent;


class Formatter implements FormatterInterface
{
    public static function products($data): array
    {
        return json_decode($data);
    }

    public static function categories($data): array
    {
        return json_decode($data);
    }

}