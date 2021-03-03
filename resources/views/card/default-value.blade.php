@if (!empty($collection->defaultValue) || $collection->defaultValue == "0")
    <div>
        <span class="font-weight-bold">Default:</span><span class="text-danger"> {{ $collection->defaultValue }}</span>
    </div>
@endif
