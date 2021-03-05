<div class="aside w-100 pt-4 ps-3">
    <div class="content ms-5 aside-elements-container">
        Member of:
        <h3 class="mb-3" style="overflow-wrap: break-word;">{!! resolve('get_api_link')($memberof) !!}</h3>
        {{-- {{$collection}} --}}
        <ul>
            @foreach ($collection as $item)
            <li>
                <a class="list-group-item" href="{{$item->longname}}">{{$item->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
