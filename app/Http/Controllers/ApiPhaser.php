<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Namespaces;
use App\Models\Functions;
use App\Models\Param;

use App\Http\Controllers\ClassesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ApiPhaser extends Controller
{
    public function show(Request $request) {
        $longname = $request['api_word'];
        Config::set('phaser_version', $request['version']);

        $namespace = Namespaces::whereLongname($longname)->first();
        $class = Classes::whereLongname($longname)->first();
        $function = Functions::whereLongname($longname)->first();
        $param = Param::whereLongname($longname)->first();

        if(!empty($namespace)) {
            $controller = new NamespacesController();
        }

        if(!empty($class)) {
            $controller = new ClassesController();
        }

        if(!empty($function)) {
            $request['petition'] = $function;
        }

        if(!empty($param)) {
            $request['petition'] = $param;
        }

        return (!empty($controller)) ? $controller->show($longname) : view('welcome');

    }
}
