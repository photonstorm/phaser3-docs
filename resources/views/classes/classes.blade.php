@extends('layouts.app')
@section('title', 'Classes')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h3>
                    Classes Section.
                </h3>
                <ul>
                    @foreach ($classes as $class)
                    <li><a href="{{ $class->longname }}">{{ $class->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
