<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Docs\Classes;

class GameobjectsController extends Controller
{
    public function index() {
        $gameobjects = Classes::where("memberof", "Phaser.GameObjects")->get()->sortBy('name');
        return view('docs.layouts.list-creator', [
            "name" => "Game Objects",
            "collections" => $gameobjects
        ]);
    }
}
