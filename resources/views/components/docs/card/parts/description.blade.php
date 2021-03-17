@if (!empty($collection->description))
    <div class="pt-2 mt-2">
        <h4>Description:</h4>
@markdown
{!! $collection->description !!}
@endmarkdown
    </div>
@endif
