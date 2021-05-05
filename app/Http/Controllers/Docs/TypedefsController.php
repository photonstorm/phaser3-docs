<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Typedefs;
use Illuminate\Http\Request;

class TypedefsController extends Controller
{
    public function show($longname)
    {

        $typedef = Typedefs::whereLongname($longname)->first();

        return view('docs.typedef', [
            "typedef" => $typedef
        ]);
    }
}
