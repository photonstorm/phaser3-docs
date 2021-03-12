<div class="d-flex justify-content-between">

    <div class="h4 ">
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
    <div class="d-none d-md-block">
        @include('components.docs.card.parts.focus-link')
    </div>
</div>
