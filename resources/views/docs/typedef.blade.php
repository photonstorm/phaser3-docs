@extends('app')
@section('title', $typedef->scope)

@section('content')
@include('docs.layouts.header')
<div class="container layout-container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-12">
            <div class="mt-4">
                @php
                $version = Config('app.phaser_version');
                $namesplit = [];
                $partlist = '';
                $parts = explode('.', $typedef->longname);

                for ($i = 0; $i < count($parts); $i++) {
                    $part = $parts[$i];

                    if ($i > 0) {
                        $partlist = $partlist . '.';
                    }

                    $partlist = $partlist . $part;

                    $namesplit[] = [$partlist, $part, $i === count($parts) - 1 ? '' : '&nbsp;.'];
                }
                @endphp
                <div class="h2 card d-flex flex-row">
                    @foreach ($namesplit as $parts)
                        <a href="{{route('docs.api.phaser', ["version" => $version, "api" => $parts[0]])}}">{!! $parts[1] !!}</a> {!! $parts[2] !!}&nbsp;
                    @endforeach
                </div>
                <x-card class="card reactive-scrollspy" :id="$typedef->name" :collection="$typedef" :focus="FALSE" />
            </div>
        </div>
    </div>
</div>
@endsection
