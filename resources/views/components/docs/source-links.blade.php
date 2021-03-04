{{-- Helps to get a card of sources link --}}
<div {{ $attributes }}>
    <span class="font-weight-bold">Source:</span>
    <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}">src/{{$metaFileRoute}}</a>
    (Line <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}#L{{$metalineno}}">{{$metalineno}}</a>)
</div>
