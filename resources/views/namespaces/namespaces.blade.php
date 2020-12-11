@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Namespaces</h3>
    <ul>
        @foreach ($namespaces as $namespace)
        <li>
            <a href="{{Config::get('app.phaser_version')}}/{{$namespace->longname}}">{{$namespace->longname}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
