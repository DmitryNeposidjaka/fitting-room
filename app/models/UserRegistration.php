<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 15.05.18
 * Time: 18:06
 */

namespace App\models;


use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    public $email;
    public $phone;
    public $name;
    public $password;

}