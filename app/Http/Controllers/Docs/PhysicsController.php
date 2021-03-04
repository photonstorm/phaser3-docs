<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Classes;

use Illuminate\Http\Request;

class PhysicsController extends Controller
{
    public function index() {
        $arcade = Classes::where("memberof", "Phaser.Physics.Arcade")->get();
        $matter = Classes::where("memberof", "Phaser.Physics.Matter")->get();
        return view('docs.physics', [
            "physics" => [
                "arcade" => $arcade,
                "matter" => $matter
            ]
        ]);
    }
}
