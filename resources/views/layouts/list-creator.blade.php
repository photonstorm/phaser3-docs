@extends('layouts.app')
@section('title', $name)
@section('content')
<div class="container layout-container landing-page px-4">
    <div class="row">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 text-center my-4">
                    <h3><u>{{$name}}</u></h3>
                </div>

                <ul>
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
