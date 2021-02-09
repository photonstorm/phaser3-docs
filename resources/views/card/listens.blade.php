@if(!empty($collection->listens))
        <div class="ps-4">
            <h4>Listens:</h4>
            <ul>
                @foreach (explode(',', $collection->listens) as $listen)
                    <li>{!! resolve('get_api_link')($listen) !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
