@extends('layouts.app')

@section('content')
<div class="container-md">
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-7">
            @yield('section_content')
        </div>
        <div class="col-12 col-lg-4 col-xl-4 offset-xl-1 d-none d-lg-block">
            @yield('aside')
        </div>
    </div>
</div>
@endsection
