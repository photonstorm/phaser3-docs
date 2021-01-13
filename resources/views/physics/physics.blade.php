@extends('layouts.app')
@section('title', 'Physics')
@section('content')
<div class="container">
    <h2>
        Physics Section.
    </h2>
    <h3>Arcade</h3>
        <ul>
            @foreach ($physics['arcade'] as $arcade)
                <li><a href="{{ $arcade->longname }}">{{ $arcade->name }}</a></li>
            @endforeach
        </ul>
    <h3>MatterJS</h3>
        <ul>
            @foreach ($physics['matter'] as $matter)
                <li><a href="{{ $matter->longname }}">{{ $matter->name }}</a></li>
            @endforeach
        </ul>
</div>
@endsection
