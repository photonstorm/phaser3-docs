@extends('layouts.app')

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
