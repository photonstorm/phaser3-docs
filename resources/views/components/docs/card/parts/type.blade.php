@if (!empty($collection->type))
    <div>
        <span class="font-weight-bold">Type:</span> <span class="text-danger">{!! resolve('get_api_link')($collection->type) !!}</span>
    </div>
@endif
