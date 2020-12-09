@extends('layouts.app')
@section('content')
<div>
    Classes Section.
    <ul>
        @foreach ($classes as $class)
            <li><a href="/class/{{ $class->longname }}">{{ $class->name }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
