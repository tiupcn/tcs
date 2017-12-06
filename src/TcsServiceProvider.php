<?php

namespace Tiup\Tcs;

use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Arr;
class TcsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('smsVerify', function ($attribute, $value, $parameters, $validator) {
            $key = $attribute.'_verify';
            $data = $validator->getData();
            $code = $data[$key];
            return \Tcs::checkVerify($value, $code);
        });
        $this->publishes([
            __DIR__.'/../config/tcs.php' => \config_path('tcs.php'),
        ], 'tcs');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Main Service
        $this->app->bind('Tiup\Tcs', function ($app) {
            $config = $app['config']->get('tcs');
            return new Tcs($config);
        });
    }
}
