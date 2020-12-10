@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-9">
            <div class="h2 text-danger">Class: {{ $class->name }}</div>
            <div class="h3 text-info">{{$class->longname }}</div>
            <p>
                {{$class->description}}
            </p>
            <hr>
            <h3>Constructor:</h3>

            <x-member-card method="new {{ $class->name }}({{$classConstructor}})" :params=$params since="{{$class->since}}" metaFileRoute="{{$class->metapath}}/{{$class->metafilename}}" metalineno="{{$class->metalineno}}"/>

            @if (count($extends))
            <h3>Extends</h3>
            <ul>
                @foreach ($extends as $extend)
                <li><a href="/class/{{$extend->object}}">{{$extend->object}}</a></li>
                @endforeach
            </ul>
            <hr>
            @endif
            @if (count($members) AND false)
            <h3>Members</h3>
            <ul>
                @foreach ($members as $member)
                <li class="mt-3">
                    <div class="text-danger h3">
                        {{$member->name}}: <b>{{$member->type}}</b>
                    </div>
                    <div>
                        {{$member->description}}
                    </div>
                    @if ($member->return != '')
                    <div class="text-info font-weight-bold">
                        Returns: <span class="text-info">{{$member->returns}}</span>
                    </div>
                    @endif
                    @if ($member->defaultValue != '')
                    <div class="text-info font-weight-bold">
                        Default: <span class="text-info">{{$member->defaultValue}}</span>
                    </div>
                    @endif
                    <small><b>Since:</b><span class="text-danger"> {{$member->since}}</span></small>
                    <small>
                        <div class="text-danger">Source:
                            <a href="https://github.com/photonstorm/phaser/blob/{{config('app.actual_phaser_version')}}/src/{{$member->metapath}}/{{$member->metafilename}}">src/{{$member->metapath}}/{{$member->metafilename}}</a>
                            <a href="https://github.com/photonstorm/phaser/blob/{{config('app.actual_phaser_version')}}/src/{{$member->metapath}}/{{$member->metafilename}}#L{{$member->metalineno}}">(Line {{$member->metalineno}})</a>
                        </div>
                    </small>
                </li>
                <hr>
                @endforeach
            </ul>
            <hr>
            @endif
            <h3>Methods</h3>

                @foreach ($methods as $method)
                @php
                    $methodConstructor = resolve('get_params_format')($method->params->all())
                @endphp
                <x-member-card
                    method="{{$method->name}}({{$methodConstructor}})"
                    :params="$method->params->all()"
                    since="{{$method->since}}"
                    metaFileRoute="{{$method->metapath}}/{{$method->metafilename}}"
                    metalineno="{{$method->metalineno}}"
                    returnsdescription="{{$method->returnsdescription}}"
                />

                @endforeach
            <hr>
        </div>
        <div class="col-3">Aside</div>
    </div>
</div>
@endsection
