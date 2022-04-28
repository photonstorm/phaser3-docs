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
                        {{-- Comprobate if exist <a in the string --}}
                        @if(strpos(resolve('get_api_link')($returntype), '<a') !== false)
                            {!! resolve('get_api_link')($returntype) !!}
                        @else
                            {{ resolve('get_api_link')($returntype) }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
