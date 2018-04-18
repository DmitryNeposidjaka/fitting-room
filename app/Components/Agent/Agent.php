<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 18:03
 */

namespace App\Components\Agent;

use App\Components\Agent\Configer;

class Agent
{
    use AgentHelper, AgentConfig;

    private $drivers = [];

    public function __construct(array $config = [])
    {
        $this->configer = new Configer($config);
        $this-> drivers = $this->initDrivers();
    }

    public function getProducts(){
        foreach ($this->drivers as $driver){
            $this->data[] = $driver->getProducts();
        }
        $merged = $this->mergeData($this->data);
        $this->resetData();
        return $merged;
    }

    public function getCategories(){
        foreach ($this->drivers as $driver){
            $this->data[] = $driver->getCategories();
        }
        $merged = $this->mergeData($this->data);
        $this->resetData();
        return $merged;
    }


}