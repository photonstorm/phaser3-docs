<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Constant;
use Illuminate\Http\Request;

class ConstantController extends Controller
{
    public function index() {
        return view('constants.constant',["constants" => Constant::all()]);
    }

    public function show($longname) {
        $constant = Constant::whereLongname($longname)->first();
        return view('constants.constant', [
            "constant" => $constant
        ]);
    }
}
