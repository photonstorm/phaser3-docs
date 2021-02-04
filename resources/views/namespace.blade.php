@extends('layouts.layout')
@section('title', $namespace->longname)

@section('section_content')
        {{-- Show namespace properties Name, methods--}}
        <div class="h2 text-danger">{{ ucfirst($namespace->getTable()) }}: {{ $namespace->name }}</div>
        <div class="h3 text-info">{{$namespace->longname }}</div>
        <x-source-links class="mb-3" metaFileRoute="{{$namespace->metapath}}/{{$namespace->metafilename}}" metalineno="{{$namespace->metalineno}}" />

        {{-- Show clases --}}
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

        {{-- Show anothers namespace --}}
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

        {{-- Show anothers namespace --}}
        {{-- Events --}}
        @if (!empty($events) AND count($events))
            <h3>Events</h3>
                @foreach ($events as $event)
                    <x-card :collection="$event" class="card" focus="true" />
                @endforeach
        @endif

        {{-- Members --}}
        @if ((count($membersConstants) AND !empty($membersConstants)) || (count($members) AND !empty($members)))
        <h3>Members</h3>
        @if (count($membersConstants))
            @foreach ($membersConstants as $memberConstant)
                <x-card :collection="$memberConstant" class="card" focus="true" :id="$memberConstant->name"/>
            @endforeach
        @elseif (count($members))
            @foreach ($members as $member)
                <x-card :collection="$member" class="card" focus="true" :id="$member->name"/>
            @endforeach
        @endif
        @endif

        {{-- methods --}}
        @if (!empty($methods) AND count($methods))
            <h3 class="mt-4">Methods</h3>
            @foreach ($methods as $method)
                @php
                    $methodConstructor = resolve('get_params_format')($method->params);
                @endphp
                <x-card :collection="$method" class="card" focus="true" :id="$method->name"/>
            @endforeach
        @endif

        {{-- Type definitions --}}
        @if (!empty($typedefs) AND count($typedefs))
        <h3>Type Definitions</h3>
            @foreach ($typedefs as $typedef)
                <x-card :collection="$typedef" class="card" :id="$typedef->name" focus="true"/>
            @endforeach
        @endif
@endsection
@section('aside')
    <x-aside
        title="Namespace: {{$namespace->name}}"
        :namespaces="$namespaces"
        :classes="$classes"
        :membersConstants="$membersConstants"
        :members="$members"
        :methods="$methods"
        :typedefs="$typedefs"
        :events="$events"
    />
@endsection
