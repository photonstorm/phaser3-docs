<?php
namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Namespaces;
use App\Models\Functions;
use App\Models\Param;

use App\Http\Controllers\ClassesController;
use App\Models\Constant;
use App\Models\Event;
use App\Models\Typedefs;
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

        $event = Event::whereLongname($longname)->first();
        $typedef = Typedefs::whereLongname($longname)->first();
        $constant = Constant::whereLongname($longname)->first();

        if(!empty($namespace)) {
            $controller = new NamespacesController();
            Config::set('app.actual_link', 'namespaces');
        }

        if(!empty($class)) {
            $controller = new ClassesController();
            Config::set('app.actual_link', 'classes');
        }

        if(!empty($event)) {
            $controller  = new EventsController();
            Config::set('app.actual_link', 'events');
        }

        if(!empty($typedef)) {
            $controller  = new TypedefsController();
            Config::set('app.actual_link', 'namespaces');
        }

        if(!empty($constant)) {
            $controller = new ConstantController();
        }

        // if(!empty($param)) {
        //     $controller  = $param;
        // }


        // TODO: send 404 if not found
        return (!empty($controller)) ? $controller->show($longname) : view('landing');

    }
}
