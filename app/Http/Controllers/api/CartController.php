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
        return $this->agent->getCart($cartToken, $customerToken);
    }

    public function toProcess(Request $request){

        return $this->agent->processingOrder();
    }

    public function add(Request $request){
        $this->validate($request, [
            'product_id'    => 'required|numeric',
            'growth_id'     => 'required|numeric',
            'size_id'       => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        $model = new Order();
        $model->product_id = $request->input('product_id');
        $model->growth_id = $request->input('growth_id');
        $model->size_id = $request->input('size_id');
        $model->amount = $request->input('amount');

        return $this->agent->addOrder($request->header('x-cart-token'), $request->header('x-customer-token'), $model);
    }

    public function delete(Request $request){
        $this->validate($request, [
            'product_id'    => 'required|numeric',
            'growth_id'     => 'required|numeric',
            'size_id'       => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        $model = new Order();
        $model->product_id = $request->input('product_id');
        $model->growth_id = $request->input('growth_id');
        $model->size_id = $request->input('size_id');
        $model->amount = $request->input('amount');

        return $this->agent->removeOrder($request->header('x-cart-token'), $request->header('x-customer-token'), $model);
    }
}