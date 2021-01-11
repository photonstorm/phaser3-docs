@extends('layouts.app')
@section('title', 'Events')
@section('content')
<div class="container">
    <h3>Events</h3>
    <ul>
        @foreach ($events as $event)
        <li>
            <a href="{{Config::get('app.phaser_version')}}/{{$event->longname}}">{{$event->longname}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
