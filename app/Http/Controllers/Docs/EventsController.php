<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use App\Models\Docs\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index() {
        $list_longnames = $this->create_longnames_list(Event::all()->pluck('longname')->toArray());
        return view('events.events',
        [
            "name" => "Events",
            "list_longnames" => $list_longnames,
            "collections" => Event::all()
        ]);
    }

    public function show($longname) {
        $event = Event::whereLongname($longname)->first();
        return view('events.event-focus', [
            "event" => $event
        ]);
    }

    private function create_longnames_list($list) {
        $acumulator = [];
        foreach($list as $key) {
            $exit = explode('.', $key);
            array_pop($exit);
            $word = implode('.', $exit);

            if(!in_array($word, $acumulator) ) {
                array_push($acumulator, $word);
            }
        }
        return $acumulator;
    }
}
