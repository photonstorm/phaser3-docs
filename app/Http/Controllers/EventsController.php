<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index() {
        return view('events.events',["events" => Event::all()]);
    }

    public function show($longname) {
        $event = Event::whereLongname($longname)->first();
        return view('events.event', [
            "event" => $event
        ]);
    }
}
