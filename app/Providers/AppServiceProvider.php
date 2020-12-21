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

        $this->app->bind('get_types', function($app) {
            return function($param_or_property) {
                $globals = $param_or_property->getGlobalTypes()->get();
                $phaser_types = $param_or_property->getPhaserTypes()->get();
                $phaser_typedef = $param_or_property->getTypedeftTypes()->get();

                $str_output = '';

                for($i = 0; $i < count($globals); $i++) {
                    if(!empty($globals[$i]->name)) {
                        if ($i === 0) {
                            $str_output .= $globals[$i]->name;
                        } else {
                            $str_output .= ' | ' . $globals[$i]->name;
                        }
                        if(count($phaser_types) OR count($phaser_typedef)) {
                            $str_output .= ' | ';
                        }
                    }

                }

                for($i = 0; $i < count($phaser_types); $i++) {
                    $link = '<a href="/'. $this->app->Config::get('app.phaser_version') .'/'. $phaser_types[$i]->name .'">' . $phaser_types[$i]->name . '</a>';
                    if(!empty($phaser_types[$i]->name)) {
                        if ($i === 0) {
                            $str_output .= $link;
                        } else {
                            $str_output .= ' | ' . $link;
                        }
                        if(count($phaser_typedef)) {
                            $str_output .= ' | ';
                        }
                    }
                }

                for($i = 0; $i < count($phaser_typedef); $i++) {
                    if(!empty($phaser_typedef[$i]->name)) {

                        $link = '<a href="/'. $this->app->Config::get('app.phaser_version') .'/'. $phaser_typedef[$i]->name .'">' . $phaser_typedef[$i]->name . '</a>';
                        if ($i === 0) {
                            $str_output .= $link;
                        } else {
                            $str_output .= ' | ' . $link;
                        }
                    }
                }

                return $str_output;
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
