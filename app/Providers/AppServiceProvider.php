<?php

namespace App\Providers;

use App\View\Components\Docs\Card;
use Illuminate\Support\Facades\Blade;
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
        $this->app->bind('get_params_format', function ($app)
        {
            return function ($params)
            {
                $constructor = '';
                foreach ($params as $key => $value)
                {
                    if ($key !== 0)
                    {
                        $constructor .= ($value['optional'] == 1) ? ', [' : ', ';
                    }
                    else
                    {
                        $constructor .= ($value['optional'] == 1) ? '[' : '';
                    }
                    $constructor .= ($value['optional'] == 1) ? $value['name'] . ']' : $value['name'];
                }
                return $constructor;
            };
        });

        // Get types from param or property relation
        $this->app->bind('get_types', function ($app)
        {
            return function ($param_or_property)
            {

                $globals = $param_or_property->getGlobalTypes()->get();
                $phaser_types = $param_or_property->getPhaserTypes()->get();
                $phaser_typedef = $param_or_property->getTypedefTypes()->get();

                $str_output = '';

                for ($i = 0; $i < count($globals); $i++)
                {
                    if (!empty($globals[$i]->name))
                    {
                        if ($i === 0)
                        {
                            $str_output .= htmlentities($globals[$i]->name);
                        }
                        else
                        {
                            $str_output .= ' | ' . htmlentities($globals[$i]->name);
                        }
                        if ((count($phaser_types) or count($phaser_typedef)) and ($i === count($globals) - 1))
                        {
                            $str_output .= ' | ';
                        }
                    }
                }

                for ($i = 0; $i < count($phaser_types); $i++)
                {
                    $link = resolve('get_api_link')($phaser_types[$i]->name);
                    if (!empty($phaser_types[$i]->name))
                    {
                        if ($i === 0)
                        {
                            $str_output .= $link;
                        }
                        else
                        {
                            $str_output .= ' | ' . $link;
                        }
                        if (count($phaser_typedef) and ($i === count($phaser_types) - 1))
                        {
                            $str_output .= ' | ';
                        }
                    }
                }

                for ($i = 0; $i < count($phaser_typedef); $i++)
                {
                    if (!empty($phaser_typedef[$i]->name))
                    {
                        $link = resolve('get_api_link')($phaser_typedef[$i]->name);
                        if ($i === 0)
                        {
                            $str_output .= $link;
                        }
                        else
                        {
                            $str_output .= ' | ' . $link;
                        }
                    }
                }

                return $str_output;
            };
        });

        // Resolve the link from a string
        $this->app->bind('get_api_link', function ($app)
        {
            return function ($type)
            {
                // var_dump(htmlentities($type));
                $pattern = '/Phaser.[a-zA-Z0-9._#]*/i';

                $clean_html_entities_type = str_replace('>', '&gt;', $type);
                $api_link_output = str_replace('<', '&lt;', $clean_html_entities_type);

                if (preg_match_all($pattern, $api_link_output, $found_type))
                {
                    $find_type = $found_type[0];
                    foreach ($find_type as $key => $value)
                    {
                        $replace_str = '<a href="' . route('docs.api.phaser', ["version" => $this->app->Config::get('app.phaser_version'), "api" => rtrim($value, '.')]) . '">' . $value . '</a>';
                        $api_link_output = str_replace($value, $replace_str, $api_link_output);
                    }
                }
                else
                {
                    // $api_link_output = '<a href="/'. $this->app->Config::get('app.phaser_version') .'/'. $type.'">' . $type . '</a>';
                    $api_link_output = $type;
                }

                return $api_link_output;
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
        //use App\Helpers\DataBaseSelector;

    }
}
