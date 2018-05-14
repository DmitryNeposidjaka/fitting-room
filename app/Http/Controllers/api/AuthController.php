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
            'login' => 'required|max:25',
            'pass' => 'required|max:25',
        ]);

        $result = $this->agent->getDriver('defaultDriver')->auth($request->input('login'), $request->input('pass'));

        return view('auth', ['result' => $result]);
    }
}