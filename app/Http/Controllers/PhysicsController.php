<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class PhysicsController extends Controller
{
    public function index() {
        $arcade = Classes::where("memberof", "Phaser.Physics.Arcade")->get();
        $matter = Classes::where("memberof", "Phaser.Physics.Matter")->get();
        return view('physics.physics', [
            "physics" => [
                "arcade" => $arcade,
                "matter" => $matter
            ]
        ]);
    }
}
