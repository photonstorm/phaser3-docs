@extends('layouts.app')
@section('content')
<div class="container layout-container">
    <div class="row">
        <div class="col-12">
            @if($collection->getTable() === 'event')
                <div class="mt-3">
                    {{-- <div class="h2 text-danger">{{ ucfirst($collection->getTable()) }}: {{ $collection->name }}</div>
                    <div class="h3 text-info">{{ $collection->longname }}</div> --}}
{{-- @markdown
{!! $collection->description !!}
@endmarkdown --}}
                @if($collection->getTable() === 'class')
                    <hr>
                    <h3>Constructor:</h3>
                    @php
                        $classConstructor = resolve('get_params_format')($collection->params->all());
                    @endphp
@markdown
```javascript
new {{ $collection->name }}({{$classConstructor}})
```
@endmarkdown
                @else
                    <x-member-card
                        class="card-members-style"
                        :params="$collection->params->all()"
                        name="{{$collection->name}}"
                        description="{{$collection->description}}"
                        since="{{$collection->since}}"
                        metaFileRoute="{{$collection->metapath}}/{{$collection->metafilename}}"
                        metalineno="{{$collection->metalineno}}"
                    />
                @endif

                </div>

            @else
                <div class="mt-3">
                    @if(!empty($collection->memberof))
                        <div class="card-member-style">
                            <h3>Member of: {!! resolve('get_api_link')($collection->memberof) !!}</h3>
                        </div>
                        @endif
                    @php
                        $params = (empty($collection->params)) ? [] : $collection->params->all();
                        $functionArguments = ($collection->getTable() === 'functions') ? "(" . resolve('get_params_format')($params) . ")"  : "";
                    @endphp

                    <x-member-card
                        class="card-members-style show-important-card"
                        name="{{$collection->name}}{{$functionArguments}}"
                        kind="function"
                        access="{{$collection->access}}"
                        :description="$collection->description"
                        :types="$collection"
                        since="{{$collection->since}}"
                        :params="$params"
                        metaFileRoute="{{$collection->metapath}}/{{$collection->metafilename}}"
                        returnstype="{{$collection->returnstype}}"
                        metalineno="{{$collection->metalineno}}"
                        defaultValue="{{$collection->defaultValue}}"
                        returnsdescription="{{$collection->returnsdescription}}"
                        overrides="{{$collection->overrides}}"
                        fires="{{$collection->fires}}"
                        inherits="{{$collection->inherits}}"
                        readOnly="{{$collection->readOnly}}"
                        nullable="{{$collection->nullable}}"
                        scope="{{$collection->scope}}"
                        :type="$collection->type"
                    />
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
