<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public function index() {
        return view('layouts.list-creator', [
            "name" => "Class",
            "collections" => Classes::all()
        ]);
    }

    public function show($longname) {
        // Config::set('database.connections.sqlite.database', database_path('3.24.1.db'));
        // DB::purge('sqlite');

        // dd(DataBaseSelector::getLastDB());

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

        // dd($class);

        return view('class', [
            "class" => $class,
            "params" => $params,
            "classConstructor" => $classConstructor,
            "extends" => $extends,
            "members" => $members,
            "membersConstants" => $membersConstants,
            "methods" => $methods,
            "methodConstructor" => ''
        ]);
    }
}
