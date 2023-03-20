@extends('app')
@section('title', $collection->name)

@section('content')
@include('docs.layouts.header')
<div class="container layout-container">
    <div class="row">
        <div class="col-12">
            @if($collection->getTable() === 'event')

                <div class="mt-3">
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
                    <x-card class="card" :collection="$collection" />
                @endif
                </div>

            @else
                <div class="mt-3">
                    @if(!empty($collection->memberof))
                        <div class="card">
                            <h3>Member of: {!! resolve('get_api_link')($collection->memberof) !!}</h3>
                        </div>
                        @endif
                    @php
                        $params = (empty($collection->params)) ? [] : $collection->params->all();
                        $functionArguments = ($collection->getTable() === 'functions') ? "(" . resolve('get_params_format')($params) . ")"  : "";
                    @endphp
                    <x-card class="card" isFocusRoute="TRUE" :collection="$collection" />
                </div>
            @endif
                {{-- Examples section --}}
                <x-examples-link :quantity="24" :searchName="$collection->name" />
        </div>
    </div>
</div>
@endsection
