<div class="d-flex justify-content-between border-bottom pb-1 mb-3">
    <div class="h4 ">
        @if ($collection->webgl == "1")
            <span class="badge bg-info text-dark">
                Only webGL
            </span>
        @endif
        @if ($getTableName() === 'members' OR $getTableName() === 'constants')
            @php
            $types = resolve('get_types')($collection);
            @endphp
            {{$getAccess()}} {{$collection->name}}: {!! $types !!}

            {{-- Typedefs / Events--}}
        @elseif($isTypedef() === 'typedefs' OR $getTableName() === 'event')
            {{$getAccess()}} {{$collection->name}}
            {{-- Functions / Methods OR if typedef is some type like function --}}
        @elseif($getTableName() === 'functions' || $isTypedef() === 'functions')
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
