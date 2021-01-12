<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchbarResource;
use App\Models\Classes;
use App\Models\Constant;
use App\Models\Event;
use App\Models\Functions;
use App\Models\Member;
use App\Models\Namespaces;
use App\Models\Typedefs;
use Illuminate\Http\Request;

class Searchbar extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->search;
        $search_array = [];

        $classes = Classes::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $classes_collection = new SearchbarResource($classes);

        $namespace = Namespaces::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $namespace_collection = new SearchbarResource($namespace);

        $events = Event::where('longname', 'like', "%$keyword%")->get()->take(5)->sortBy("longname")->flatten(1);
        $events_collection = new SearchbarResource($events);

        $functions = Functions::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $functions_collection = new SearchbarResource($functions);

        $constants = Constant::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $constants_collection = new SearchbarResource($constants);

        $members = Member::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $members_collection = new SearchbarResource($members);

        $typedef = Typedefs::where('longname', 'like', "%$keyword%")->get()->sortBy("longname")->take(5)->flatten(1);
        $typedef_collection = new SearchbarResource($typedef);


        if (empty($keyword)) {
            $search_array = [];
        } else {
            // search by this.add
            if (str_starts_with($keyword, "this.")) {
                $keys = explode('.', $keyword);

                $scene_members_class = Member::where("memberof", "Phaser.Scene")->where("name", "like", "%$keys[1]%");

                $scene_collection = [];

                if (!$scene_members_class->get()->isEmpty()) {

                    if (count($keys) <= 2) {

                        $scene_collection = new SearchbarResource($scene_members_class->get());

                        array_push($search_array, [
                            "type" => "scene",
                            "data" => $scene_collection
                        ]);
                        // dd($members_class->get);
                    } else if (count($keys) < 4) {
                        $type = $scene_members_class->first()->type;
                        $members = Functions::where("memberof", $type)->where("name", "like", "%$keys[2]%");
                        $member_collection = new SearchbarResource($members->get());

                        array_push($search_array, [
                            "type" => "scene",
                            "data" => $member_collection
                        ]);
                    }
                }
            }

            // Normal search

            // ---- Namespaces
            if (!$namespace_collection->isEmpty()) {
                $namespace_filter = new SearchbarResource($namespace_collection->filter(function($namespace) {
                    return ( !str_contains($namespace->longname, 'Type') );
                }));
                // dd($namespace_filter);
                if(!$namespace_filter->isEmpty()) {
                    array_push($search_array, [
                        "type" => "namespaces",
                        "data" => $namespace_filter
                    ]);
                }
            }

            // ---- Classes
            if (!$classes_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "classes",
                        "data" => $classes_collection
                    ]
                );
            }

            // ---- Members
            if (!$members_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "members",
                        "data" => $members_collection
                    ]
                );
            }

            // ---- Functions
            if (!$functions_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "function",
                        "data" => $functions_collection
                    ]
                );
            }

            // ---- Events
            if (!$events_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "events",
                        "data" => $events_collection
                    ]
                );
            }

            // ---- Constants
            if (!$constants_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "constants",
                        "data" => $constants_collection
                    ]
                );
            }

            // ---- Typedef
            if (!$typedef_collection->isEmpty()) {
                array_push(
                    $search_array,
                    [
                        "type" => "typedef",
                        "data" => $typedef_collection
                    ]
                );
            }
        }

        return $search_array;
    }
}
