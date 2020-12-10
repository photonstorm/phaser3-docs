<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Get the constructor format: (option1, option1 [, option3])
        $this->app->bind('get_params_format', function($app) {
            return function($params) {
                $constructor = '';
                foreach($params as $key => $value) {
                    if($key !== 0) {
                        $constructor .= ($value['optional'] == 1) ? ' [, ' : ', ';
                    }
                    $constructor .= ($value['optional'] == 1) ? $value['name'].']' : $value['name'];
                }
                return $constructor;
            };

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
