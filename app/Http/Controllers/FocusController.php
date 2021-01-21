<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Constant;
use App\Models\Event;
use App\Models\Functions;
use App\Models\Member;
use App\Models\Namespaces;
use App\Models\Param;
use App\Models\Typedefs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class FocusController extends Controller
{
    public function index(Request $request) {
        $longname = $request['api_word'];
        $version = $request['version'];

        $namespace = Namespaces::whereLongname($longname)->first();
        $class = Classes::whereLongname($longname)->first();

        $function = Functions::whereLongname($longname)->first();
        $members = Member::whereLongname($longname)->first();

        $event = Event::whereLongname($longname)->first();
        $typedef = Typedefs::whereLongname($longname)->first();
        $constant = Constant::whereLongname($longname)->first();

        $collection = collect();

        if(!empty($namespace)) {
            return redirect("$version/$longname");
        }

        if(!empty($class)) {
            return redirect("$version/$longname");
        }

        if(!empty($members)) {
            $collection = $members;
        }

        if(!empty($event)) {
            $collection = $event;
        }

        if(!empty($function)) {
            $collection = $function;
        }

        if(!empty($typedef)) {
            $collection = $typedef;
        }

        if(!empty($constant)) {
            $collection = $constant;
        }

        if(empty($collection->all())) {
            return abort(404);
        }

        return view('focus', ['collection' => $collection]);

    }
}
