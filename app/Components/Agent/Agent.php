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
        $this->drivers = $this->initDrivers();
    }

    /**
     * @param string $driver
     * @return DriverInterface|null
     */
    public function getDriver($driver)
    {
        return (array_key_exists($driver, $this->drivers))? $this->drivers[$driver] : null;
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