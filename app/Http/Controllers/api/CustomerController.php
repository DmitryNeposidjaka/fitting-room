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
use App\models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
        $response = $this->agent->getCustomerData($request->header('x-customer-token'));
        return new Response($response['data'], $response['status']);
    }

    public function updateData(Request $request)
    {
        $customer = new Customer();
        $customer->setAll($request->all());

        $response = $this->agent->updateCustomerData($request->header('x-customer-token'), $customer);
        return new Response($response['data'], $response['status']);
    }

    public function getOrders(Request $request){
        $response = $this->agent->getCustomerOrders($request->header('x-customer-token'));
        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }
}