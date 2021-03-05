{{-- Principal layout with aside and container, use in: http://127.0.0.1:8000/3.52.0/Phaser.Game --}}
@extends('app')

@include('docs.layouts.header')

@section('content')
<div class="container-fluid layout-container">
    <div class="row">
        <div class="col-12 col-lg-4 col-xl-3 d-none d-lg-block px-0 aside-container">
            <div class="aside-fixed">
                @yield('aside')
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-9 pt-4 ps-4">
            @yield('section_content')
        </div>
    </div>
</div>
@endsection
