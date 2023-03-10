@extends('docs.layouts.layout')

@section('title', $class->longname)

@section('section_content')

<div class="d-none d-lg-block">
    <div class="issue-card issue-card-strip w-100 mt-2 py-1 h3">
        This is a <strong>beta</strong> release of our new docs system. Found an <strong>issue</strong>?<br /> Please tell us about it in the <strong>#</strong>📖<strong>-newdocs-feedback</strong> channel
        on the <a href="https://discord.gg/phaser"> Phaser Discord</a>
    </div>

    <h1 class="py-2">
        @foreach ($namesplit as $parts)
        <a href="{{route('docs.api.phaser', ["version" => $version, "api" => $parts[0]])}}">{{ $parts[1] }}</a> {{ $parts[2] }}
        @endforeach
    </h1>
</div>
<div class="p-4">
    <div class="float-none float-lg-end d-flex d-lg-block justify-content-center mx-3">
        <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
            id="_carbonads_js"></script>
    </div>
    {{-- Mobile name --}}
    <div class="d-block d-lg-none">
        <div class="issue-card issue-card-strip w-100 mt-3 py-1 h3">
            This is a <strong>beta</strong> release of our new docs system. Found an <strong>issue</strong>?<br /> Please tell us about it in the <strong>#</strong>📖<strong>-newdocs-feedback</strong> channel
            on the <a href="https://discord.gg/phaser"> Phaser Discord</a>
        </div>
        <h1 class="my-3">
            @foreach ($namesplit as $parts)
            <a href="{{route('docs.api.phaser', ["version" => $version, "api" => $parts[0]])}}">{{ $parts[1] }}</a> {{ $parts[2] }}
            @endforeach
        </h1>
    </div>
@markdown
{!! $class->description !!}
@endmarkdown
</div>

{{-- <p class="font-monospace">Source file: {{ $class->metapath }}/{{ $class->metafilename }}</p>
{{-- <p class="font-monospace">Added in Phaser v{{ $class->since }}</p> --}}

<h3>Constructor:</h3>
@php
    $classConstructor = resolve('get_params_format')($params)
@endphp

@markdown
```javascript
new {{ $class->name }}({{$classConstructor}})
```
@endmarkdown
    <x-create-table-params-properties
        class="mt-1 pt-2 pb-4"
        :collection="$class"
    />

    @if (!empty($extends) AND count($extends))
    <h3 class="mt-4">Extends</h3>
    <ul>
        @foreach ($extends as $extend)
        <li>
            {!! resolve('get_api_link')($extend->object) !!}
        </li>
        @endforeach
    </ul>
    <hr>
    @endif

    {{-- Members --}}
    @if ((!empty($members) AND count($members)) OR (!empty($membersConstants) AND count($membersConstants)))
        <h2 class="mt-4">Members</h2>
        @foreach ($membersConstants as $memberConstant)
                <x-card class="card reactive-scrollspy" :id="$memberConstant->name" :collection="$memberConstant" focus="true" />
            @endforeach
            @foreach ($members as $member)
                <x-card class="card reactive-scrollspy" :id="$member->name" :collection="$member" focus="true"/>
            @endforeach
    @endif

    {{-- Methods --}}
    @if (!empty($methods) AND count($methods))
        <h2 class="mt-4">Methods</h2>
            @foreach ($methods as $method)
            @php
                $methodConstructor = resolve('get_params_format')($method->params->all())
            @endphp
                <x-card class="card reactive-scrollspy" :id="$method->name" :collection="$method" focus="true"/>
            @endforeach
    @endif

    {{-- Examples section --}}
    <x-examples-link :quantity="24" :searchName="$class->longname" />
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
