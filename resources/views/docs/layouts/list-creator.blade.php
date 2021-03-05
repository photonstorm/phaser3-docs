{{-- Help us to create main lists, IE: http://127.0.0.1:8000/3.52.0/namespaces --}}
@extends('app')
@section('title', $name)

@include('docs.layouts.header')

@section('content')
<div class="container layout-container landing-page px-4">
    <div class="row">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 text-center my-4 border-bottom">
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
    </div>
</div>
@endsection
