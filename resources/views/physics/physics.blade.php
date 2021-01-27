@extends('layouts.app')
@section('title', 'Physics')
@section('content')
<div class="container layout-container landing-page px-4">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h2>
                    <u>
                        Physics Section.
                    </u>
                </h2>
                <h3>
                    <u>
                        Arcade
                    </u>
                </h3>
                <div class="row">
                    @foreach ($physics['arcade'] as $arcade)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{ $arcade->longname }}" class="btn-primary">{{ $arcade->name }}</a>
                    </div>
                    @endforeach
                </div>
                <h3 class="mt-3">MatterJS</h3>
                <div class="row">
                    @foreach ($physics['matter'] as $matter)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{ $matter->longname }}" class="btn-primary">{{ $matter->name }}</a>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
