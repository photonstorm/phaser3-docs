@extends('layouts.app')
@section('title', $event->longname)
@section('content')
<div class="container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-9">
            <div class="h2 text-danger">{{ ucfirst($event->getTable()) }}: {{ $event->name }}</div>
            <div class="h3 text-info">{{$event->longname }}</div>
            <x-member-card
                class="border-bottom border-danger mt-0 pt-0 pb-4 "
                scope="{{$event->scope}}"
                :description="$event->description"
                :type="$event->type"
                since="{{$event->since}}"
                :params="$event->params->all()"
                metaFileRoute="{{$event->metapath}}/{{$event->metafilename}}"
                metalineno="{{$event->metalineno}}"
                {{-- :returnstype="$method->returnstype" --}}
                {{-- returnsdescription="{{$method->returnsdescription}}" --}}
            />
        </div>
        <div class="col-3">
            Aside
        </div>

    </div>
</div>
@endsection
