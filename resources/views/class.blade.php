@extends('layouts.layout')
@section('title', $class->longname)

@section('section_content')
    <div class="class-header">
        <div class="h2 text-danger">{{ ucfirst($class->getTable()) }}: {{ $class->name }}</div>
        <div class="h3 text-info">{{ $class->longname }}</div>
@markdown
{!! $class->description !!}
@endmarkdown
    </div>
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
            <li><a href="/{{Config::get('app.phaser_version')}}/{{$extend->object}}">{{$extend->object}}</a></li>
            @endforeach
        </ul>
        <hr>
        @endif
        {{-- Members --}}
        @if ((!empty($members) AND count($members)) OR (!empty($membersConstants) AND count($membersConstants)))
            <h2 class="mt-4">Members</h2>
            @foreach ($membersConstants as $memberConstant)
                    <x-member-card
                        :id="$memberConstant->name"
                        class="card-members-style animate__animated"
                        name="{{$memberConstant->name}}"
                        access="{{$memberConstant->access}}"
                        :description="$memberConstant->description"
                        kind="constant"
                        :types="$memberConstant"
                        since="{{$memberConstant->since}}"
                        metaFileRoute="{{$memberConstant->metapath}}/{{$memberConstant->metafilename}}"
                        metalineno="{{$memberConstant->metalineno}}"
                        defaultValue="{{$memberConstant->defaultValue}}"
                        returnsdescription="{{$memberConstant->returnsdescription}}"
                        overrides="{{$memberConstant->overrides}}"
                        inherits="{{$memberConstant->inherits}}"
                        readOnly="{{$memberConstant->readOnly}}"
                        nullable="{{$memberConstant->nullable}}"
                        longname="{{$memberConstant->longname}}"
                        focus="true"

                    />
                @endforeach
                @foreach ($members as $member)
                    <x-member-card
                        :id="$member->name"
                        class="card-members-style animate__animated"
                        name="{{$member->name}}"
                        access="{{$member->access}}"
                        :description="$member->description"
                        kind="member"
                        :types="$member"
                        since="{{$member->since}}"
                        metaFileRoute="{{$member->metapath}}/{{$member->metafilename}}"
                        metalineno="{{$member->metalineno}}"
                        defaultValue="{{$member->defaultValue}}"
                        returnsdescription="{{$member->returnsdescription}}"
                        overrides="{{$member->overrides}}"
                        inherits="{{$member->inherits}}"
                        readOnly="{{$member->readOnly}}"
                        :examples="$member->getExamples->all()"
                        nullable="{{$member->nullable}}"
                        scope="{{$member->scope}}"
                        longname="{{$member->longname}}"
                        focus="true"
                    />
                @endforeach
        @endif
        {{-- Methods --}}
        @if (!empty($methods) AND count($methods))
            <h2 class="mt-4">Methods</h2>
                @foreach ($methods as $method)
                @php
                    $methodConstructor = resolve('get_params_format')($method->params->all())
                @endphp
                <x-member-card
                    :id="$method->name"
                    class="card-members-style animate__animated"
                    name="{{$method->name}}({{$methodConstructor}})"
                    scope="{{$method->scope}}"
                    :description="$method->description"
                    :params="$method->params->all()"
                    since="{{$method->since}}"
                    metaFileRoute="{{$method->metapath}}/{{$method->metafilename}}"
                    metalineno="{{$method->metalineno}}"
                    fires="{{$method->fires}}"
                    inherits="{{$method->inherits}}"
                    returnstype="{{$method->returnstype}}"
                    returnsdescription="{{$method->returnsdescription}}"
                    longname="{{$method->longname}}"
                    focus="true"
                />
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
