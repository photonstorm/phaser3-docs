@extends('layouts.app')
@section('title', $typedef->scope)
@section('content')
<div class="container layout-container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-12">
            <div class="mt-4">
                <div class="h2">Type Definition</div>
                {{-- <div class="h3 text-info">{{$typedef->longname }}</div> --}}
                <x-member-card
                class="card-show"
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
        </div>
    </div>
</div>
@endsection
