<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Classes;
use App\Models\Docs\Constant;
use App\Models\Docs\Typedefs;
use App\Models\Docs\Namespaces;
use App\Models\Docs\Event;
use App\Http\Controllers\Docs\ClassesController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ApiPhaserController extends Controller
{
    public function show(Request $request) {
        $longname = $request['api'];
        Config::set('phaser_version', $request['version']);

        $namespace = Namespaces::whereLongname($longname)->first();
        $class = Classes::whereLongname($longname)->first();

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

        // TODO: send 404 if not found
        return (!empty($controller)) ? $controller->show($longname) : view('landing');

    }
}
