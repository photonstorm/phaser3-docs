<?php

namespace App\Providers;

use App\Models\Classes;
use App\Models\Namespaces;
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

        $this->app->bind('get_namespace_class_link', function($app) {
            return function($param) {
                // Exists the namespace?
                if (count(Namespaces::all()->where('longname', $param))) {
                    return 'namespace';
                } elseif ( count( Classes::all()->where('longname', $param) ) ) {
                    return 'class';
                } else {
                    return '';
                }
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
