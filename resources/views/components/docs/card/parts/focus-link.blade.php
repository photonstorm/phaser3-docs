@if($focus)
<div class="d-flex justify-content-end justify-content-md-end">
    <div class="me-2">
        <a href="focus/{{$collection->longname}}" class="d-flex align-items-center align-middle"><img src="{{asset('images/aim.png')}}" width="25" alt="Focus"></a>
    </div>
    <div class="copy-members-to-clipboard">
        <a href="#{{$collection->name}}" class="d-flex align-items-center align-middle"><img src="{{asset('images/hashtag.png')}}" alt="Focus" width="25" id="{{url()->to('')}}/docs/{{Config::get('app.phaser_version')}}/{{$collection->memberof}}#{{$collection->name}}"></a>
    </div>
</div>
@endif
