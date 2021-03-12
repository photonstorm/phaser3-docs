@if($focus)
<div class="d-flex justify-content-end justify-content-md-end">
    <div class="me-2 align-middle">
        <a href="focus/{{$collection->longname}}"><img src="{{asset('images/aim.png')}}" alt="Focus"></a>
    </div>
    <div class="copy-members-to-clipboard">
        <a href="#{{$collection->name}}"><img src="{{asset('images/hashtag.png')}}" alt="Focus" width="30" id="{{url()->to('')}}/{{Config::get('app.phaser_version')}}/focus/{{$collection->longname}}"></a>
    </div>
</div>
@endif
