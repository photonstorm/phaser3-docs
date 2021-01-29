{{-- Test 1 http://localhost:8000/3.52.0/Phaser.Game#plugins --}}
{{-- Test Constants: http://localhost:8000/3.52.0/Phaser.Core.Config --}}
<div {{ $attributes->merge([
    'class' => ( (($collection->access == 'private') ? 'private hide-card' : '' ) .' '. ((!empty($collection->inherits)) ? 'inherited' : ''))
]) }}>
    {{-- Members or membersConstants --}}
    <div class="d-flex justify-content-between">
        {{-- name --}}
        <div class="h4 text-danger" id="{{ $id }}">

            @if ($getTableName() === 'members' OR $getTableName() === 'constants')
                @php
                $types = resolve('get_types')($collection);
                @endphp
                {{$getAccess()}} {{$collection->name}}: {!! $types !!}

            {{-- Typedefs / Events--}}
            @elseif($getTableName() === 'typedefs' OR $getTableName() === 'event')
                {{$getAccess()}} {{$collection->name}}
            {{-- Functions / Methods --}}
            @elseif($getTableName() === 'functions')
                @php
                $methodConstructor = resolve('get_params_format')($collection->params);
                @endphp
                {{$getAccess()}} {{$collection->name}}({!! $methodConstructor !!})
            @endif
        </div>
        @if($focus)
            <div class="d-flex">
                <div class="mr-2 align-middle">
                    <a href="focus/{{$collection->longname}}"><img src="{{asset('images/aim.png')}}" alt="Focus"></a>
                </div>
                <div class="copy-members-to-clipboard">
                    <a href="#{{$collection->name}}"><img src="{{asset('images/hashtag.png')}}" alt="Focus" width="30" id="{{url()->to('')}}/{{Config::get('app.phaser_version')}}/focus/{{$collection->longname}}"></a>
                </div>
            </div>
        @endif
    </div>
    @if (!empty($collection->description))
        <div class="border-top pt-2 mt-2">
            <h4>Description:</h4>
@markdown
{!! $collection->description !!}
@endmarkdown
        </div>
    @endif
    @if (!collect($collection->params)->isEmpty())
        <h4>
            Parameters:
        </h4>
        <table class="table table-light table-striped table-bordered shadow-sm">
            <thead class="thead-light">
                <tr>
                    @foreach ($create_table_params_properties as $key => $value)
                        @if($value)
                            @if($key == 'defaultValue')
                                <th scope="col">Default</th>
                            @else
                                <th scope="col">{{$key}}</th>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($collection->params as $param)
                <tr>
                    {{-- Name --}}
                    @if ($create_table_params_properties()['name'])
                        <th scope="row">{{ $param->name }}</th>
                    @endif
                    {{-- Type --}}
                    @if ($create_table_params_properties()['type'])
                        <td>
                            {!! resolve('get_types')($param) !!}
                        </td>
                    @endif
                    {{-- Arguments --}}
                    @if ($create_table_params_properties()['arguments'])
                        <td>
                            @if ($param->optional == 1)
                            {{"<optional>"}}
                            @endif
                        </td>
                    @endif
                    {{-- Default --}}
                    @if ($create_table_params_properties()['defaultValue'])
                        <td>{{$param->defaultValue}}</td>
                    @endif
                    {{-- Description --}}
                    @if ($create_table_params_properties()['description'])
                        <td>
@markdown
{!! $param->description !!}
@endmarkdown
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- properties --}}
    @if (!collect($collection->properties)->isEmpty())
        <h5>
            Properties:
        </h5>
        <table class="table table-light table-striped table-bordered shadow-sm">
            <thead class="thead-light">
                <tr>
                        @foreach ($create_table_params_properties as $key => $value)
                            @if($value)
                                @if($key == 'defaultValue')
                                    <th scope="col">Default</th>
                                @else
                                    <th scope="col">{{$key}}</th>
                                @endif
                            @endif
                        @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($collection->properties as $property)
                <tr>
                    {{-- Name --}}
                    @if ($create_table_params_properties()['name'])
                        <th scope="row">{{ $property->name }}</th>
                    @endif
                    {{-- Type --}}
                    @if ($create_table_params_properties()['type'])
                    <td>
                        {!! resolve('get_types')($property) !!}
                    </td>
                    @endif
                    {{-- Arguments --}}
                    @if ($create_table_params_properties()['arguments'])
                    <td>
                        @if ($property->optional == 1)
                        {{"<optional>"}}
                        @endif
                    </td>
                    @endif
                    {{-- Default --}}
                    @if ($create_table_params_properties()['defaultValue'])
                        <td>{{$property->defaultValue}}</td>
                    @endif
                    @if ($create_table_params_properties()['description'])
                    {{-- Description --}}
                    <td>
@markdown
{!! $property->description !!}
@endmarkdown
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    {{-- Type --}}
    @if (!empty($collection->type))
        <div>
            <span class="font-weight-bold">Type:</span> <span class="text-danger">{!! resolve('get_api_link')($collection->type) !!}</span>
        </div>
    @endif

    {{-- Functions - ReturnsDescription --}}
    @if(!empty($collection->returnsdescription))
        <div class="pl-3">
            <h4>Returns:</h4>
            <div class="pl-4">
@markdown
{!! $collection->returnsdescription !!}
@endmarkdown
            </div>
        </div>
    @endif

    {{-- ReturnsType --}}
    @if(!empty($collection->returnstype))
    <div class="pl-3">
        <h4>Type:</h4>
        <div class="pl-4">
            <ul>
                @foreach (explode('|', $collection->returnstype) as $returntype)
                    <li>
                        {!! resolve('get_api_link')($returntype) !!}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    @if (!empty($collection->defaultValue) || $collection->defaultValue == "0")
        <div>
            <span class="font-weight-bold">Default:</span><span class="text-danger"> {{ $collection->defaultValue }}</span>
        </div>
    @endif
    @if(!empty($collection->inherits))
        <div>Inherited from: {!! resolve('get_api_link')($collection->inherits) !!}</div>
    @endif
    @if(!empty($collection->overrides))
        <div>Overrides:  {!! resolve('get_api_link')($collection->overrides) !!}</div>
    @endif

    {{-- Fires --}}
    @if(!empty($collection->fires))
        <div class="pl-4">
            <h4>Fires:</h4>
            <ul>
                @foreach (explode(',', $collection->fires) as $fire)
                    <li>{!! resolve('get_api_link')($fire) !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Listeners --}}
    {{-- Fires --}}
    @if(!empty($collection->listens))
        <div class="pl-4">
            <h4>Listens:</h4>
            <ul>
                @foreach (explode(',', $collection->listens) as $listen)
                    <li>{!! resolve('get_api_link')($listen) !!}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Examples --}}
    @if(!empty($examples))
        <div>
            <span class="font-weight-bold">Examples:</span>
            <ul>
                @foreach ($collection->getExamples->all() as $example)
                    <li>

@markdown
```javascript
{{$example->example}}
```
@endmarkdown
                    </li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Source and Since --}}
    <div class="border-top mt-2 pt-2">
        <div>
            <span class="font-weight-bold">Since:</span> <span class="text-danger">{{ $collection->since }}</span>
        </div>

        <div>
            <span class="font-weight-bold">Source:</span>
            <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}">src/{{$metaFileRoute}}</a>
            (Line <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}#L{{$collection->metalineno}}">{{$collection->metalineno}}</a>)
        </div>
    </div>
</div>
