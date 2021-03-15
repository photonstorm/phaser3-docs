@extends('app')
@section('title', $name)


@section('content')
@include('docs.layouts.header')
<div class="container-fluid px-4">
    <div class="row">

        <div class="offset-0 offset-lg-1 offset-xl-3 col-12 col-lg-8 col-xl-6 order-2 order-lg-1 layout-container landing-page px-4">
            <div class="row mt-3">
                <div class="col-12 text-center my-4 border-bottom">
                    <h3>{{$name}}</h3>
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
        <div class="col-12 col-lg-2 col-xl-3 mt-4 order-1 d-flex flex-column flex-lg-row d-lg-block justify-content-center">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
                id="_carbonads_js"></script>
                <div class="issue-card mt-3 h3">
                    This is a <strong>beta</strong> release of our new docs system. <br />Found an <strong>issue</strong>?<br /> Please tell us about it in the <strong>#</strong>📖<strong>-newdocs-feedback</strong> channel
                    on the <a href="https://discord.gg/phaser"> Phaser Discord</a>
                </div>
        </div>
    </div>
</div>
@endsection
