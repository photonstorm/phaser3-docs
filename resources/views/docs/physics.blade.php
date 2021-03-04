@extends('app')
@section('title', 'Physics')
@section('content')
<div class="container layout-container landing-page px-4">
    <div class="row">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 text-center my-4 border-bottom">
                    <h3>Physics</h3>
                </div>
                <div class="mt-4">
                    <h3>
                        <u>
                            Arcade
                        </u>
                    </h3>
                    <div class="row">
                        <div class="col-12">
                            <ul class="ps-4">
                                @foreach ($physics['arcade'] as $arcade)
                                <li>
                                    <a href="{{ $arcade->longname }}">{{ $arcade->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <h3 class="mt-3">MatterJS</h3>
                    <div class="row">
                        <div class="col-12">
                            <ul class="ps-4">
                                @foreach ($physics['matter'] as $matter)
                                <li>
                                    <a href="{{ $matter->longname }}">{{ $matter->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection