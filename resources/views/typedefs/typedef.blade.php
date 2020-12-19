@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        {{-- TODO: continue here, create a system to separate the types --}}
        @php
            $test = "Phaser.Scene | Array.<{{remplace}}> | Phaser.Types.Scenes.SettingsConfig | Array.<Phaser.Types.Scenes.SettingsConfig> | Phaser.Types.Scenes.CreateSceneFromObjectConfig | Array.<Phaser.Types.Scenes.CreateSceneFromObjectConfig> | function | Array.<function()>";
            $var = "Phaser.Scene";
        @endphp
        {{$test}}
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
                metaFileRoute="{{$typedef->metafilename}}"
                metalineno="{{$typedef->metalineno}}"
            />
        </div>
        <div class="col-3">
            {{-- Aside --}}
        </div>

    </div>
</div>
@endsection
