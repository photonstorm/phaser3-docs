<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Classes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public function index()
    {
        return view('docs.layouts.list-creator', [
            "name" => "Class",
            "collections" => Classes::all(),
            "version" => Config::get('app.phaser_version')
        ]);
    }

    public function show($longname)
    {
        // If exist cache
        $cache = Cache::get("docs.scene.$longname");
        if ($cache && !env('APP_DEBUG')) {
            return $cache;
        }

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

        for ($i = 0; $i < count($parts); $i++) {
            $part = $parts[$i];

            if ($i > 0) {
                $partlist = $partlist . '.';
            }

            $partlist = $partlist . $part;

            $namesplit[] = [$partlist, $part, $i === count($parts) - 1 ? '' : '.'];
        }

        $var_view = [
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
        ];

        // Cache system: if is in debug mode then don't set cache
        if (env('APP_DEBUG')) {
            return view('docs.class', $var_view);
        } else {
            return Cache::remember("docs.scene.$longname", Carbon::parse('1 week'), function () use ($var_view) {
                return view('docs.class', $var_view)->render();
            });
        }
    }
}
