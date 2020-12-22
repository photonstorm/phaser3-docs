<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index() {
        return view('classes.classes', ["classes" => Classes::all()]);
    }

    public function show($longname) {
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

        return view('classes.class', [
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
