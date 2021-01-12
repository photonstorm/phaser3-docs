@extends('layouts.app')
@section('title', 'Gameobjects')
@section('content')
<div class="container">
    <h3>
        Gameobjects Section.
    </h3>
    <ul>
        @foreach ($gameobjects as $gameobject)
            <li><a href="{{ $gameobject->longname }}">{{ $gameobject->name }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
