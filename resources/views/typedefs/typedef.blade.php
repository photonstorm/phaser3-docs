@extends('layouts.app')
@section('title', $typedef->scope)
@section('content')
<div class="container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-9">
            <div class="h2">Type Definition</div>
            {{-- <div class="h3 text-info">{{$typedef->longname }}</div> --}}
            <x-member-card
                class="border-bottom border-danger mt-0 pt-0 pb-4 "
                name="{{$typedef->name}}"
                scope="{{$typedef->scope}}"
                :description="$typedef->description"
                :type="$typedef->type"
                since="{{$typedef->since}}"
                :params="$typedef->params->all()"
                :properties="$typedef->properties->all()"
                metaFileRoute="{{$typedef->metapath}}/{{$typedef->metafilename}}"
                metalineno="{{$typedef->metalineno}}"
            />
        </div>
        <div class="col-3">
            {{-- Aside --}}
        </div>

    </div>
</div>
@endsection
