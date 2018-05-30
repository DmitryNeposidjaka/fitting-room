<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 30.05.18
 * Time: 16:52
 */

namespace App\Http\Controllers\api;


use App\Components\Agent\Agent;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * @var \App\Components\Agent\Driver|null
     */
    private $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent->getDriver('defaultDriver');
    }

    public function getData(Request $request){
        return $this->agent->getCustomerData();
    }

    public function getOrders(Request $request){
        return $this->agent->getCustomerOrders();
    }
}