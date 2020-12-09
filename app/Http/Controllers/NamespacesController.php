<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Namespaces;
use Illuminate\Http\Request;

class NamespacesController extends Controller
{
    public function show() {
        return view('namespaces.namespaces', ['namespaces' => Namespaces::all()]);
    }

    public function showNamespace($namespace) {
        // dd(Classes::where('memberof', $namespace)->first());
        $classes = Classes::whereMemberof($namespace)->get();
        // dd( Namespaces::where('memberof', $namespace)->get()->namespaces()->get());
        return view('namespaces.namespace', [
            'classes' => $classes,
            'namespaces' => Namespaces::where('memberof', $namespace)->get()
            ]
        );
    }
}
