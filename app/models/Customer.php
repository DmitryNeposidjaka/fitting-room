<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 30.05.18
 * Time: 16:36
 */

namespace App\models;

/**
 * Class Customer
 * @package App\models
 */
class Customer
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $password;
    /**
     * @var array
     */
    public $measures;



    public function toArray(){
        return (array) $this;
    }

    public function setAll(array $data){
        foreach ($data as $k => $v){
            if(property_exists($this, $k)){
                if(json_decode($v)){
                    $this->$k = json_decode($v, true);
                }else{
                    $this->$k = $v;
                }
            }
        }
    }
}