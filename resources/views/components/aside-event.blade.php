<div class="aside w-100 pt-4 pl-3" id="scrollspy_aside">
    <div class="content">
        <h3 class="mb-3" style="overflow-wrap: break-word;">{!! resolve('get_api_link')($memberof) !!}</h3>
        {{-- {{$collection}} --}}
        <ul>
            @foreach ($collection as $item)
            <li>
                <a class="list-group-item" href="#{{$item->name}}">{{$item->name}}</a>
            </li>
            @endforeach
        </ul>

    </div>
</div>
