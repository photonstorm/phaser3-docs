@if(!empty($collection->fires))
        <div class="ps-4">
            <h4>Fires:</h4>
            <ul>
                @foreach (explode(',', $collection->fires) as $fire)
                    <li>{!! resolve('get_api_link')($fire) !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
