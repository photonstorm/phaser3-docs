@extends('layouts.app')
@section('title', 'Events')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h3>Events</h3>
                <ul>
                    @foreach ($events as $event)
                    <li>
                        <a href="focus/{{$event->longname}}">{{$event->longname}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
