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

                @foreach ($list_longnames as $longname)
                <div class="col-12 mt-4 ps-3">
                    <h2>{{$longname}}</h2>

                    @php
                    $salida = $collections->filter(function($item) use($longname) {
                    return false !== stristr($item->longname, $longname);
                    });
                    @endphp
                    <ul>
                        @foreach ($salida as $item)
                        <li>
                            <a href="{{$item['longname']}}">{{$item['name']}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
