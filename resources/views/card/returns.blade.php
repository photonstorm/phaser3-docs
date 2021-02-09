@if(!empty($collection->returnsdescription))
        <div class="ps-3">
            <h4>Returns:</h4>
            <div class="ps-4">
@markdown
{!! $collection->returnsdescription !!}
@endmarkdown
            </div>
        </div>
    @endif

    {{-- ReturnsType --}}
    @if(!empty($collection->returnstype))
    <div class="ps-3">
        <h4>Type:</h4>
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
