<?php

namespace App\Http\Controllers\Docs;
use App\Http\Controllers\Controller;

use App\Models\Docs\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public function index() {
        return view('docs.layouts.list-creator', [
            "name" => "Class",
            "collections" => Classes::all(),
            "version" => Config::get('app.phaser_version')
        ]);
    }

    public function show ($longname)
    {
        $class = Classes::whereLongname($longname)->firstOrFail();

        $params = $class->params->all();

        $extends = $class->extends;

        $members = $class->members->sortByDesc([
            ['scope', 'desc'],
            ['longname', 'asc'],
        ]);

        $membersConstants = $class->membersConstants->sortBy("longname");

        $methods = $class->functions->sortBy("longname");

        $classConstructor = resolve('get_params_format')($params);

        $version = Config::get('app.phaser_version');

        $namesplit = [];
        $partlist = '';
        $parts = explode('.', $class->longname);

        for ($i = 0; $i < count($parts); $i++)
        {
            $part = $parts[$i];

            if ($i > 0)
            {
                $partlist = $partlist . '.';
            }

            $partlist = $partlist . $part;

            $namesplit[] = [ $partlist, $part, $i === count($parts) - 1 ? '' : '.' ];
        }

        // dd($class);

        return view('docs.class', [
            "class" => $class,
            "params" => $params,
            "classConstructor" => $classConstructor,
            "extends" => $extends,
            "members" => $members,
            "membersConstants" => $membersConstants,
            "methods" => $methods,
            "methodConstructor" => '',
            "namesplit" => $namesplit,
            "version" => $version
        ]);
    }
}
