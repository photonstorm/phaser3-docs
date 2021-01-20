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
        @if (!empty($events) AND count($events))
            <h3>Events</h3>
                @foreach ($events as $event)
                <x-member-card
                    :id="$event->name"
                    class="card-show"
                    name="{{$event->name}}"
                    description="{!! $event->description !!}"
                    :params="$event->params->all()"
                    :types="$event"
                    since="{{$event->since}}"
                    metaFileRoute="{{$event->metapath}}/{{$event->metafilename}}"
                    metalineno="{{$event->metalineno}}"
                />
                @endforeach
        @endif

        {{-- Members --}}
        @if ((count($membersConstants) AND !empty($membersConstants)) || (count($members) AND !empty($members)))
        <h3>Members</h3>
        @if (count($membersConstants))
            @foreach ($membersConstants as $memberConstant)
                <x-member-card
                    class="card-show"
                    name="{{$memberConstant->name}}"
                    scope="{{$memberConstant->scope}}"
                    description="{!! $memberConstant->description !!}"
                    kind="constant"
                    :types="$memberConstant"
                    since="{{$memberConstant->since}}"
                    metaFileRoute="{{$memberConstant->metafilename}}"
                    metalineno="{{$memberConstant->metalineno}}"
                />
            @endforeach
        @elseif (count($members))
            @foreach ($members as $member)
            <x-member-card
                class="card-show"
                name="{{$member->name}}"
                scope="{{$member->scope}}"
                description="{!! $member->description !!}"
                kind="member"
                :types="$member"
                since="{{$member->since}}"
                metaFileRoute="{{$member->metapath}}/{{$member->metafilename}}"
                metalineno="{{$member->metalineno}}"
            />
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
            <x-member-card
                    class="card-show"
                    scope="{{$method->scope}}"
                    name="{{$method->name}}({{$methodConstructor}})"
                    :description="$method->description"
                    :type="$method->type"
                    since="{{$method->since}}"
                    scope="{{$method->scope}}"
                    :params="$method->params->all()"
                    metaFileRoute="{{$method->metapath}}/{{$method->metafilename}}"
                    metalineno="{{$method->metalineno}}"
                    :returnstype="$method->returnstype"
                    returnsdescription="{{$method->returnsdescription}}"
                />
            @endforeach
        @endif

        {{-- Type definitions --}}
        @if (!empty($typedefs) AND count($typedefs))
        <h3>Type Definitions</h3>
            @foreach ($typedefs as $typedef)
            <x-member-card
                :id="$typedef->name"
                class="card-show"
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
