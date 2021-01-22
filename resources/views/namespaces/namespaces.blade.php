@extends('layouts.app')
@section('title', "Namespaces")
@section('content')
<div class="container layout-container">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h3>Namespaces</h3>
                <ul>
                    @foreach ($namespaces as $namespace)
                    <li>
                        <a href="{{$namespace->longname}}">{{$namespace->longname}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
