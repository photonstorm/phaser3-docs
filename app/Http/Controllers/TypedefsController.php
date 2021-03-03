<?php

namespace App\Http\Controllers;

use App\Models\Docs\Typedefs;
use Illuminate\Http\Request;

class TypedefsController extends Controller
{
    public function show($longname)
    {

        $typedef = Typedefs::whereLongname($longname)->first();

        return view('typedefs.typedef', [
            "typedef" => $typedef
        ]);
    }
}
