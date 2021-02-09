<div class="d-flex justify-content-between">

<div class="h4" id="{{ $id }}">

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
                <div class="me-2 align-middle">
                    <a href="focus/{{$collection->longname}}"><img src="{{asset('images/aim.png')}}" alt="Focus"></a>
                </div>
                <div class="copy-members-to-clipboard">
                    <a href="#{{$collection->name}}"><img src="{{asset('images/hashtag.png')}}" alt="Focus" width="30" id="{{url()->to('')}}/{{Config::get('app.phaser_version')}}/focus/{{$collection->longname}}"></a>
                </div>
            </div>
        @endif
        </div>
