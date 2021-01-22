@extends('layouts.app')
@section('title', 'Gameobjects')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h3>
                    Gameobjects Section.
                </h3>
                <ul>
                    @foreach ($gameobjects as $gameobject)
                    <li><a href="{{ $gameobject->longname }}">{{ $gameobject->name }}</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
