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

            return function($type, $longname = "") {

                $namespace = Namespaces::whereLongname($type)->first();
                $class = Classes::whereLongname($type)->first();
                $function = Functions::whereLongname($type)->first();
                $param = Param::whereLongname($type)->first();
                $event = Event::whereLongname($type)->first();
                $type_def = Typedefs::whereLongname($type)->first();

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
