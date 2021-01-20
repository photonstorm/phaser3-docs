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

class FocusController extends Controller
{
    public function index(Request $request) {
        $longname = $request['api_word'];
        // TODO: Show:
        /*
        members

        */

        $namespace = Namespaces::whereLongname($longname)->first();
        $class = Classes::whereLongname($longname)->first();

        $function = Functions::whereLongname($longname)->first();
        $param = Param::whereLongname($longname)->first();
        $members = Member::whereLongname($longname)->first();

        $event = Event::whereLongname($longname)->first();
        $typedef = Typedefs::whereLongname($longname)->first();
        $constant = Constant::whereLongname($longname)->first();

        return view('focus');

    }
}
