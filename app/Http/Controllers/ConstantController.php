<?php

namespace App\Http\Controllers;

use App\Models\Constant;
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
