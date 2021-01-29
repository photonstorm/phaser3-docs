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
                {{-- <x-member-card
                id="{{$event->name}}"
                class="card-members-style mt-0 pt-0 pb-4 "
                scope="{{$event->scope}}"
                :description="$event->description"
                :type="$event->type"
                since="{{$event->since}}"
                :params="$event->params->all()"
                metaFileRoute="{{$event->metapath}}/{{$event->metafilename}}"
                metalineno="{{$event->metalineno}}"
                /> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('aside')
    <x-aside-event memberof="{{$event->memberof}}" />
@endsection
