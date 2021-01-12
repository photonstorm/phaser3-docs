@extends('layouts.app')
@section('title', 'Constants')
@section('content')
<div class="container">
    <h3>Constants</h3>
    <ul>
        @foreach ($constants as $constant)
        <li>
            <a href="{{$constant->longname}}">{{$constant->longname}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
