<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public $version;

    public function __construct ()
    {
        $this->version = Config::get('app.phaser_version');
    }

    public function index ()
    {
        return view ('layouts.list-creator', [
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

        // $classConstructor = resolve('get_params_format')($params);

        $classConstructor = $this->getParamsFormat($params);

        // $version = Config::get('app.phaser_version');

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

        $hasMembers = (!empty($members) && count($members) > 0) || (!empty($membersConstants) && count($membersConstants) > 0);
        $hasMethods = (!empty($methods) && count($methods) > 0);
        $hasExtends = (!empty($extends) && count($extends) > 0);

        // dd($class);

        return view('docs.class', [
            "version" => $this->version,
            "class" => $class,
            "classConstructor" => $classConstructor,
            "namesplit" => $namesplit,
            "extends" => $extends,
            "params" => $params,
            "members" => $members,
            "membersConstants" => $membersConstants,
            "methods" => $methods,
            "methodConstructor" => '',
            "hasMembers" => $hasMembers,
            "hasMethods" => $hasMethods,
            "hasExtends" => $hasExtends
        ]);
    }

    public function getParamsFormat ($params)
    {
        $constructor = '';

        foreach ($params as $key => $value)
        {
            if ($key !== 0)
            {
                $constructor .= ($value['optional'] == 1) ? ', [' : ', ';
            }
            else
            {
                $constructor .= ($value['optional'] == 1) ? '[' : '';
            }

            $constructor .= ($value['optional'] == 1) ? $value['name'].']' : $value['name'];
        }

        return $constructor;
    }

}
