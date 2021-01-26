@extends('layouts.app')
@section('title', $name)
@section('content')
<div class="container layout-container">
    <div class="row">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 text-center my-4">
                    <h3>{{$name}}</h3>
                </div>

                @foreach ($collections as $collection)
                <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                    <a href="{{$collection->longname}}" class="btn-primary">{{$collection->longname}}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
