<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class GameobjectsController extends Controller
{
    public function index() {
        $gameobjects = Classes::where("memberof", "Phaser.GameObjects")->get()->sortBy('name');
        return view('gameobjects.gameobjects', ["gameobjects" => $gameobjects]);
    }
}
