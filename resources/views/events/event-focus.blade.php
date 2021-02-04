@extends('layouts.layout')
@section('title', $event->longname)
@section('section_content')
<div class="container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-12">
            <div class="mt-3">
                <div class="h2 text-danger">{{ ucfirst($event->getTable()) }}: {{ $event->name }}</div>
                <div class="h3 text-info">{{$event->longname }}</div>
                <x-card :id="$event->name" class="card" :collection="$event" />
            </div>
        </div>
    </div>
</div>
@endsection
@section('aside')
    <x-aside-event memberof="{{$event->memberof}}" />
@endsection
