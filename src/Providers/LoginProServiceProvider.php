<?php

namespace masoudnabavi\LoginPro\Providers;

use Illuminate\Support\ServiceProvider;


class LoginProServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'login_pro');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/LoginPro.php', 'login_pro');
        $this->publishes([
            __DIR__ . '/../config/LoginPro.php' => config_path('login_pro.php'),
        ]);
    }

    public function register()
    {

    }
}
