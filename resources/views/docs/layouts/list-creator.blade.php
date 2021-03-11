{{-- Help us to create main lists, IE: http://127.0.0.1:8000/3.52.0/namespaces --}}
@extends('app')
@section('title', $name)

@section('content')
@include('docs.layouts.header')
<div class="container-fluid px-4">
    <div class="row">
        <div class="offset-0 offset-lg-1 offset-xl-3 col-12 col-lg-8 col-xl-6 order-2 order-lg-1 layout-container landing-page">
            <div class="row mt-4">
                <div class="col-12 text-center my-3 border-bottom">
                    <h3>{{$name}}</h3>
                </div>

                <ul class="ps-5">
                    @foreach ($collections as $collection)
                    <li>
                        <a href="{{$collection->longname}}">{{$collection->longname}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-2 col-xl-3 mt-4 order-1 d-flex d-lg-block justify-content-center">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
                id="_carbonads_js"></script>
        </div>
    </div>
</div>
@endsection
