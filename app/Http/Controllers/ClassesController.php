<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function show() {
        return view('classes.classes', ["classes" => Classes::all()]);
    }

    public function showClass($longname) {
        $class = Classes::whereLongname($longname)->first();
        $params = $class->params->where('parentFunction', '')->all();
        $extends = $class->extends;
        $members = $class->members;

        $classConstructor = '';
        // Get the constructor format: (option1, option1, [option3])
        foreach($params as $key => $value) {
            if($key !== 0) {
                $classConstructor .= ($value['optional'] == 1) ? ' [, ' : ', ';
            }
            $classConstructor .= ($value['optional'] == 1) ? $value['name'].']' : $value['name'];
        }

        return view('classes.class', [
            "class" => $class,
            "params" => $params,
            "classConstructor" => $classConstructor,
            "extends" => $extends,
            "members" => $members
        ]);
    }
}
