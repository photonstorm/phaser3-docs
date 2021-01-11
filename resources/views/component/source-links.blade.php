{{-- Helps to get a card of sources link --}}
<div {{ $attributes }}>Source:
    <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}">src/{{$metaFileRoute}}</a>
    <a href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}#L{{$metalineno}}">(Line {{$metalineno}})</a>

</div>
