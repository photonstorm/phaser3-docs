@extends('docs.layouts.layout')

@section('title', $class->longname)

@section('section_content')

<h1 class="py-2">
@foreach ($namesplit as $parts)
    <a href="{{route('docs.api.phaser', ["version" => $version, "api" => $parts[0]])}}">{{ $parts[1] }}</a> {{ $parts[2] }}
@endforeach
</h1>

<div class="p-4">
@markdown
{!! $class->description !!}
@endmarkdown
</div>

<p class="font-monospace">Source file: {{ $class->metapath }}/{{ $class->metafilename }}</p>
<p class="font-monospace">Added in Phaser v{{ $class->since }}</p>

<h3>Constructor:</h3>
@php
    $classConstructor = resolve('get_params_format')($params)
@endphp

@markdown
```javascript
new {{ $class->name }}({{$classConstructor}})
```
@endmarkdown

<x-member-card
    class="mt-1 pt-2 pb-4"
    :params=$params
    since="{{$class->since}}"
    metaFileRoute="{{$class->metapath}}/{{$class->metafilename}}"
    metalineno="{{$class->metalineno}}"
/>

    @if (!empty($extends) AND count($extends))
    <h3 class="mt-4">Extends</h3>
    <ul>
        @foreach ($extends as $extend)
        <li><a href="{{route('docs.api.phaser', ['version' => $version, 'api' => $extend->object])}}">{{ $extend->object }}</a></li>
        @endforeach
    </ul>
    <hr>
    @endif

    {{-- Members --}}
    @if ((!empty($members) AND count($members)) OR (!empty($membersConstants) AND count($membersConstants)))
        <h2 class="mt-4">Members</h2>
        @foreach ($membersConstants as $memberConstant)
                <x-card class="card" :id="$memberConstant->name" :collection="$memberConstant" focus="true" />
            @endforeach
            @foreach ($members as $member)
                <x-card class="card" :id="$member->name" :collection="$member" focus="true"/>
            @endforeach
    @endif

    {{-- Methods --}}
    @if (!empty($methods) AND count($methods))
        <h2 class="mt-4">Methods</h2>
            @foreach ($methods as $method)
            @php
                $methodConstructor = resolve('get_params_format')($method->params->all())
            @endphp
                <x-card class="card" :id="$method->name" :collection="$method" focus="true"/>
            @endforeach
    @endif

@endsection

@section('aside')
    <x-aside
        class="w-100"
        title="Class: {{$class->name}}"
        :membersConstants="$membersConstants"
        :members="$members"
        :methods="$methods"
    />
@endsection
