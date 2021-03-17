@if(!empty($collection->returnsdescription))
    <div>
        <h5><strong>Returns:</strong></h5>
        <div class="ms-4">
            <h5>
                Description:
            </h5>
            <div class="ps-4">
@markdown
{!! $collection->returnsdescription !!}
@endmarkdown
            </div>
        </div>
@endif

{{-- ReturnsType --}}
@if(!empty($collection->returnstype))
    <div class="ms-4">
        <h5>Type:</h5>
        <div class="ps-4">
            <ul>
                @foreach (explode('|', $collection->returnstype) as $returntype)
                    <li>
                        {!! resolve('get_api_link')($returntype) !!}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
