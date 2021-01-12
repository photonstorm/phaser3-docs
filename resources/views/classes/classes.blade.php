@extends('layouts.app')
@section('title', 'Classes')
@section('content')
<div class="container">
    <h3>
        Classes Section.
    </h3>
    <ul>
        @foreach ($classes as $class)
            <li><a href="{{ $class->longname }}">{{ $class->name }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
