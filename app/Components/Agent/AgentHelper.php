<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 18.04.18
 * Time: 11:42
 */

namespace App\Components\Agent;


trait AgentHelper
{
    protected $data = [];

    protected function mergeData(array ...$data){
        $res = [];
        foreach ($data[0] as $d){
            $res = array_merge($res,$d);
        }
        return $res;
    }

    protected function resetData(){
        $this->data = array();
    }
}