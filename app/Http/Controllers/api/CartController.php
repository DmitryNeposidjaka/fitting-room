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
use App\models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * @var \App\Components\Agent\Driver|null
     */
    private $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent->getDriver('defaultDriver');
    }

    public function getToken(Request $request){
        $token = $request->header('X-Customer-Token');

        return $this->agent->getCartToken($token);
    }

    public function getCart(Request $request){
        $cartToken = $request->header('X-Cart-Token');
        $customerToken = $request->header('X-Customer-Token');
        $response = $this->agent->getCart($cartToken, $customerToken);
        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }

    public function toProcess(Request $request){

        $model = null;
        $response = $this->agent->processingOrder($request->header('x-cart-token'), $request->header('x-customer-token'), $model);
        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }

    public function add(Request $request){
        $this->validate($request, [
            'product_id'    => 'required|string',
            'growth_id'     => 'required|string',
            'size_id'       => 'required|string',
            'amount'        => 'required|numeric',
        ]);

        $model = new Order();
        $model->product_id = $request->input('product_id');
        $model->growth_id = $request->input('growth_id');
        $model->size_id = $request->input('size_id');
        $model->amount = $request->input('amount');

        $response = $this->agent->addOrder($request->header('x-cart-token'), $request->header('x-customer-token'), $model);
        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }

    public function delete(Request $request){
        $this->validate($request, [
            'product_id'    => 'required|string',
            'growth_id'     => 'required|string',
            'size_id'       => 'required|string',
            'amount'        => 'required|numeric',
        ]);

        $model = new Order();
        $model->product_id = $request->input('product_id');
        $model->growth_id = $request->input('growth_id');
        $model->size_id = $request->input('size_id');
        $model->amount = $request->input('amount');

        $response = $this->agent->removeOrder($request->header('x-cart-token'), $request->header('x-customer-token'), $model);
        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }
}