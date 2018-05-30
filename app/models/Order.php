<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 30.05.18
 * Time: 13:54
 */

namespace App\models;

/**
 * Class Order
 * @package App\models
 * @param $product_id int
 * @param $growth_id int
 * @param $size_id int
 * @param $amount int
 */
class Order
{
    /**
     * ID товара
     * @var int
     */
    public $product_id;
    /**
     * ID роста
     * @var int
     */
    public $growth_id;
    /**
     * ID размера
     * @var int
     */
    public $size_id;
    /**
     * ID количества
     * @var int
     */
    public $amount;
}