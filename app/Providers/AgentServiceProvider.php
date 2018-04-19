<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 17.04.18
 * Time: 17:58
 */

namespace App\Providers;

use App\Components\Agent\Agent;
use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Agent::class, function ($app) {
            return new Agent(['conf_path' => dirname(__DIR__).'/Components/Agent/config.php']);
        });
    }
}