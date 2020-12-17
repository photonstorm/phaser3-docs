<?php

namespace App\Providers;

use App\Models\Classes;
use App\Models\Event;
use App\Models\Functions;
use App\Models\Namespaces;
use App\Models\Param;
use App\Models\Typedefs;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\PseudoTypes\True_;

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
                    } else {
                        $constructor .= ($value['optional'] == 1) ? '[' : '';
                    }
                    $constructor .= ($value['optional'] == 1) ? $value['name'].']' : $value['name'];
                }
                return $constructor;
            };

        });

        $this->app->bind('get_api_link', function($app) {
            return function($longname) {
                $namespace = Namespaces::whereLongname($longname)->first();
                $class = Classes::whereLongname($longname)->first();
                $function = Functions::whereLongname($longname)->first();
                $param = Param::whereLongname($longname)->first();
                $event = Event::whereLongname($longname)->first();
                $type_def = Typedefs::whereLongname($longname)->first();

                $return = FALSE;

                if(!empty($namespace)) {
                    $return = TRUE;
                }

                if(!empty($class)) {
                    $return = TRUE;
                }

                if(!empty($event)) {
                    $return = TRUE;
                }

                if(!empty($type_def)) {
                    $return = TRUE;
                }

                return $return;
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
