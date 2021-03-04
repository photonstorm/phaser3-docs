@if(!empty($collection->inherits))
    <div>
        Inherited from: {!! resolve('get_api_link')($collection->inherits) !!}
    </div>
@endif
