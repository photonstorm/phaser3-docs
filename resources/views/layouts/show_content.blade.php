@extends('layouts.app')

@section('content')
<div class="container-md" >
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8">
            @yield('section_content')
        </div>
        <div class="col-12 col-lg-4 col-xl-4 d-none d-lg-flex justify-content-end">
            @yield('aside')
        </div>
    </div>
</div>
@endsection
