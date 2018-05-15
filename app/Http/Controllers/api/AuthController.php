<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 14:00
 */

namespace App\Http\Controllers\api;


use App\Components\Agent\Agent;
use App\Http\Controllers\Controller;
use App\models\UserRegistration;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function auth(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|max:40',
            'pass' => 'required|max:25',
        ]);

        $result = $this->agent->getDriver('defaultDriver')->auth($request->input('login'), $request->input('pass'));

        return view('auth', ['result' => $result]);
    }

    public function registration(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:40',
            'name' => 'required|max:25',
            'phone' => 'required|max:25',
            'password' => 'required|max:25',
        ]);

        $model = new UserRegistration();
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->phone = $request->input('phone');
        $model->password = $request->input('password');

        $result = $this->agent->getDriver('defaultDriver')->registration($model);

        return view('auth', ['result' => $result]);
    }
}