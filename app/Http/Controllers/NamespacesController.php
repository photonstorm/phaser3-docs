<?php

namespace App\Http\Controllers;

use App\Models\Docs\Namespaces;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class NamespacesController extends Controller
{
    public function index()
    {
        return view('layouts.list-creator', [
            "name" => "Namespace",
            "collections" => Namespaces::all()->sortBy("longname")
        ]);
    }

    public function show($longname)
    {

        $namespace = Namespaces::whereLongname($longname)->first();
        $classes = $namespace->classes;
        $namespaces = $namespace->namespaces;
        $methods = $namespace->functions;
        $typedefs = $namespace->typedefs;
        $members = $namespace->members->sortBy("longname");
        $membersConstants = $namespace->membersConstants->sortBy("longname");
        $events = $namespace->events->sortBy("longname");
        $methodConstructor = "";

        return view('namespace', [
            "version" => Config::get('app.phaser_version'),
            "namespace" => $namespace,
            "classes" => $classes,
            "namespaces" => $namespaces,
            "methods" => $methods,
            "methodConstructor" => $methodConstructor,
            "typedefs" => $typedefs,
            "members" => $members,
            "membersConstants" => $membersConstants,
            "events" => $events
        ]);
    }
}
