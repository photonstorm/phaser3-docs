@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-9">
            <div class="h2 text-danger">{{ ucfirst($namespace->getTable()) }}: {{ $namespace->name }}</div>
            <div class="h3 text-info">{{$namespace->longname }}</div>
            <x-source-links class="mb-3" metaFileRoute="{{$namespace->metapath}}/{{$namespace->metafilename}}" metalineno="{{$namespace->metalineno}}" />

            @if (!empty($methods) AND count($methods))
            <h3 mt-4>Methods</h3>
            @foreach ($methods as $method)
                @php
                    $methodConstructor = resolve('get_params_format')($method->paramsNamespace);
                @endphp
            <x-member-card
                    class="border-bottom border-danger mt-2 pt-2 pb-4"
                    scope="{{$method->scope}}"
                    name="{{$method->name}}({{$methodConstructor}})"
                    :description="$method->description"
                    :type="$method->type"
                    since="{{$method->since}}"
                    scope="{{$method->scope}}"
                    :params="$method->paramsNamespace->all()"
                    metaFileRoute="{{$method->metapath}}/{{$method->metafilename}}"
                    metalineno="{{$method->metalineno}}"
                    :returnstype="$method->returnstype"
                    returnsdescription="{{$method->returnsdescription}}"
                />
            @endforeach
            @endif

            {{-- Show clases and namespace list --}}
            @if (!empty($classes) AND count($classes))
            <h3>Classes</h3>
            <ul>
                @foreach ($classes as $class)
                <li>
                    <a href="/{{Config::get('app.phaser_version')}}/{{$class->longname}}">
                        {{  $class->name }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
            @if (!empty($namespaces) AND count($namespaces))
            <h3>Namespace</h3>
            <ul>
                @foreach ($namespaces as $namespace)
                <li>
                    <a href="/{{Config::get('app.phaser_version')}}/{{$namespace->longname}}">
                        {{ $namespace->name }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif

            {{-- Members --}}
            @if (count($membersConstants) AND !empty($membersConstants))
                <h3>Members</h3>
                @foreach ($membersConstants as $memberConstant)
                    <x-member-card
                        class="border-bottom border-danger mt-2 pt-2 pb-4"
                        name="{{$memberConstant->name}}"
                        scope="{{$memberConstant->scope}}"
                        kind="constant"
                        type="{{$memberConstant->type}}"
                        since="{{$memberConstant->since}}"
                        metaFileRoute="{{$memberConstant->metafilename}}"
                        metalineno="{{$memberConstant->metalineno}}"
                    />
                @endforeach
            @endif

            {{-- Type definitions --}}
            @if (!empty($typedefs) AND count($typedefs))
            <h3>Type Definitions</h3>
                @foreach ($typedefs as $typedef)
                <x-member-card
                    class="border-bottom border-danger mt-2 pt-2 pb-4"
                    longname="{{$typedef->longname}}"
                    kind="typedef"
                    name="{{$typedef->name}}"
                    description="{{$typedef->description}}"
                    type="{{$typedef->type}}"
                    :params="$typedef->params->all()"
                    :properties="$typedef->properties->all()"
                />
                @endforeach
            @endif
        </div>
        <div class="col-3">
            {{-- Aside --}}
        </div>

    </div>
</div>
@endsection
