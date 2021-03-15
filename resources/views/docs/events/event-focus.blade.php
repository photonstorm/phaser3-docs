@extends('docs.layouts.layout')
@section('title', $event->longname)
@section('section_content')
{{-- Show namespace properties Name, methods--}}
<div class="issue-card issue-card-strip w-100 mt-2 py-1 h3">
    This is a <strong>beta</strong> release of our new docs system. Found an <strong>issue</strong>?<br /> Please tell us about it in the <strong>#</strong>📖<strong>-newdocs-feedback</strong> channel
    on the <a href="https://discord.gg/phaser"> Phaser Discord</a>
</div>
<div class="mt-3">
    <div class="h2 text-danger">{{ ucfirst($event->getTable()) }}: {{ $event->name }}</div>
    <div class="h3 text-info">{{$event->longname }}</div>
    <x-card :id="$event->name" class="card" :collection="$event" />
</div>
@endsection
@section('aside')
    <x-aside-event memberof="{{$event->memberof}}" />
@endsection
