<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Classes;
use App\Models\Docs\Constant;
use App\Models\Docs\Functions;
use App\Models\Docs\Member;
use App\Models\Docs\Namespaces;
use App\Models\Docs\Typedefs;
use App\Models\Docs\Event;

use Illuminate\Http\Request;

class FocusController extends Controller
{
    public function index(Request $request)
    {
        $longname = $request['api'];
        $version = $request['version'];

        $namespace = Namespaces::whereLongname($longname)->first();
        $class = Classes::whereLongname($longname)->first();

        $function = Functions::whereLongname($longname)->first();
        $members = Member::whereLongname($longname)->first();

        $event = Event::whereLongname($longname)->first();
        $typedef = Typedefs::whereLongname($longname)->first();
        $constant = Constant::whereLongname($longname)->first();

        $collection = collect();

        if (!empty($namespace))
        {
            return redirect("$version/$longname");
        }

        if (!empty($class))
        {
            return redirect("$version/$longname");
        }

        if (!empty($members))
        {
            $collection = $members;
        }

        if (!empty($event))
        {
            $collection = $event;
        }

        if (!empty($function))
        {
            $collection = $function;
        }

        if (!empty($typedef))
        {
            $collection = $typedef;
        }

        if (!empty($constant))
        {
            $collection = $constant;
        }

        if (empty($collection->all()))
        {
            return abort(404);
        }

        return view('docs.focus', ['collection' => $collection]);
    }
}
