@if (!empty($collection->type))
    <div>
        <h5>Type:</h5> <div class="text-danger ms-4">{!! resolve('get_types')($collection) !!}</div>
    </div>
@endif
