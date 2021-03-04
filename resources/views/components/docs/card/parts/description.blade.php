@if (!empty($collection->description))
    <div class="border-top pt-2 mt-2">
        <h4>Description:</h4>
@markdown
{!! $collection->description !!}
@endmarkdown
    </div>
@endif
