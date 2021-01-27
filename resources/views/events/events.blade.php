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

                @foreach ($list_longnames as $longname)
                    <div class="col-12 mt-4">
                        <h2>{{$longname}}</h2>
                    </div>
                    @php
                        $salida = $collections->filter(function($item) use($longname) {
                            return false !== stristr($item->longname, $longname);
                        });
                    @endphp
                    @foreach ($salida as $item)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{$item['longname']}}" class="btn-primary">{{$item['longname']}}</a>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
