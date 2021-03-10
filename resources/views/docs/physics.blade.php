@extends('app')
@section('title', 'Physics')

@section('content')
@include('docs.layouts.header')
<div class="container-fluid px-4 px-md-0">
    <div class="row">
        <div class="offset-0 offset-lg-1 offset-xl-3 col-12 col-lg-8 col-xl-6 order-2 order-md-1 layout-container landing-page px-4">
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
        <div class="col-12 col-lg-2 col-xl-3 mt-4 order-1 d-flex d-md-block justify-content-center">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
                id="_carbonads_js"></script>
        </div>
    </div>
</div>
@endsection
