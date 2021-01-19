<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Member;
use Illuminate\Http\Request;

class ScenesController extends Controller
{
    public function index() {
        $class_scene = Classes::where("longname", "Phaser.Scene")->get()->sortBy('name');
        $memberof_scenes = Classes::where("memberof", "Phaser.Scenes")->get()->sortBy('name');
        $scene_members_class = Member::where("memberof", "Phaser.Scene")->get()->sortBy('name');

        return view('scenes.scenes', [
            "class_scene" => $class_scene,
            "memberof_scenes" => $memberof_scenes,
            "scene_members_class" => $scene_members_class
        ]);
    }
}