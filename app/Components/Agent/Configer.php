<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 12:09
 */

namespace App\Components\Agent;


use function Composer\Autoload\includeFile;

class Configer
{
    private $drivers = [];

    public function __construct(array $config)
    {
        if(empty($config['conf_path'])) throw new \ErrorException('config path doesn\'t set');
        try{
            $config_file = require_once($config['conf_path']);
        }catch (\ErrorException $e){
            throw new \ErrorException('can\'t find config file');
        }
        $this->setDrivers($config_file['drivers']);


    }

    public function getDrivers(){
        return $this->drivers;
    }

    public function setDrivers(array $drivers){
        $this->drivers = $drivers;
    }

    public function addDriver(array $driver){
        if($merged = array_merge($this->drivers, $driver)){
            $this->drivers = $merged;
            unset($merged);
            return true;
        }
        return false;
    }

    public function removeDriver(string $name){
        if(isset($this->drivers[$name])){
            unset($this->drivers[$name]);
            return true;
        }
        return false;
    }
}