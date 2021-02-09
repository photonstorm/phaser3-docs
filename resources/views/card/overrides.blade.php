@if(!empty($collection->overrides))
        <div>Overrides:  {!! resolve('get_api_link')($collection->overrides) !!}</div>
    @endif
