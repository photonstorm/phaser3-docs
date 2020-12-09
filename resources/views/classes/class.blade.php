@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-9">
            <div class="h2 text-danger">Class: {{ $class->name }}</div>

            <x-member-card :title="$class"/>

            <div class="h3 text-info">{{$class->longname }}</div>
            <p>
                {{$class->description}}
            </p>
            <hr>
            <h3>Constructor:</h3>
            <ul class="h4">
                <li>
                    <span class="text-info">new </span><span
                        class="text-danger">{{ $class->name }}({{$classConstructor}})</span>
                </li>
            </ul>
            @if (count($params))
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Arguments</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($params as $param)
                    <tr>
                        <th scope="row">{{ $param->name }}</th>
                        <td>{{$param->type}}</td>
                        <td>
                            @if ($param->optional == 1)
                            {{"<optional>"}}
                            @endif
                        </td>
                        <td>{{$param->description}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <div class="text-danger h5">Since: {{$class->since}}</div>
            <div class="text-danger h5">Source: <a
                    href="https://github.com/photonstorm/phaser/blob/v3.22.0/src/{{$class->metapath}}/{{$class->metafilename}}">src/{{$class->metapath}}/{{$class->metafilename}}
                    (Line {{$class->metaline}})</a></div>
            <hr>
            @if (count($extends))
            <h3>Extends</h3>
            <ul>
                @foreach ($extends as $extend)
                <li><a href="/class/{{$extend->object}}">{{$extend->object}}</a></li>
                @endforeach
            </ul>
            <hr>
            @endif
            <h3>Members</h3>
            <ul>
                @foreach ($members as $member)
                <li class="mt-3">
                    <div class="text-danger">
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
                </li>
                <hr>
                @endforeach
            </ul>
        </div>
        <div class="col-3">Aside</div>
    </div>
</div>
@endsection
