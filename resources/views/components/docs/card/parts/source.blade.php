<div class="border-top mt-2 pt-2">
    <div>
        <span class="font-weight-bold">Since:</span> <span class="text-danger">{{ $collection->since }}</span>
    </div>

    <div>
        <span class="font-weight-bold">Source:</span>
        <a
            href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}">src/{{$metaFileRoute}}</a>
        (Line <a
            href="https://github.com/photonstorm/phaser/blob/v{{config('app.phaser_version')}}/src/{{$metaFileRoute}}#L{{$collection->metalineno}}">{{$collection->metalineno}}</a>)
    </div>
</div>
<div class="d-block d-md-none">
    @include('components.docs.card.parts.focus-link')
</div>
