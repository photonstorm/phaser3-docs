@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-9">
            <div class="h2 text-danger">{{ ucfirst($class->getTable()) }}: {{ $class->name }}</div>
            <div class="h3 text-info">{{$class->longname }}</div>
            <p>
                {{$class->description}}
            </p>
            <hr>
            <h3>Constructor:</h3>
            <x-member-card
                class="border-bottom border-danger mt-1 pt-2 pb-4"
                method="new {{ $class->name }}({{$classConstructor}})"
                :params=$params
                since="{{$class->since}}"
                metaFileRoute="{{$class->metapath}}/{{$class->metafilename}}"
                metalineno="{{$class->metalineno}}"
            />

            @if (!empty($extends) AND count($extends))
            <h3>Extends</h3>
            <ul>
                @foreach ($extends as $extend)
                <li><a href="/class/{{$extend->object}}">{{$extend->object}}</a></li>
                @endforeach
            </ul>
            <hr>
            @endif
            @if (!empty($members))
            <h3 class="mt-4">Members</h3>
                @foreach ($members as $member)
                <x-member-card
                    class="border-bottom border-danger mt-2 pt-2 pb-4"
                    method="{{$member->name}}: {{$member->type}}"
                    :description="$member->description"
                    :type="$member->type"
                    since="{{$member->since}}"
                    metaFileRoute="{{$member->metapath}}/{{$member->metafilename}}"
                    metalineno="{{$member->metalineno}}"
                    defaultValue="{{$member->defaultValue}}"
                    returnsdescription="{{$member->returnsdescription}}"
                />
                @endforeach
            <hr>
            @endif
            <h3>Methods</h3>

                @foreach ($methods as $method)
                @php
                    $methodConstructor = resolve('get_params_format')($method->params->all())
                @endphp
                <x-member-card
                    class="border-bottom border-danger mt-1 pt-2 pb-4"
                    method="{{$method->name}}({{$methodConstructor}})"
                    :description="$method->description"
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
