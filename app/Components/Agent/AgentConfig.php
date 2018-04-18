<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 12:05
 */

namespace App\Components\Agent;

use App\Components\Agent\Configer;

trait AgentConfig
{
    protected $configer;

    public function initDrivers(){
        $drivers = [];
        if($this->checkConf()){
            foreach ($this->configer->getDrivers() as $name => $options){
                $driver  = new $options['class']($options);
                if(!($driver instanceof DriverInterface)) throw new \ErrorException('The driver must be an instance of DriverInterface');
                $drivers[$name] = $driver;
            }
        }
        return $drivers;
    }

    private function checkConf(){
        return $this->configer instanceof Configer;
    }
}