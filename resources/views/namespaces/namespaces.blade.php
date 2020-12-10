@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Namespaces</h3>
    <ul>
        @foreach ($namespaces as $namespace)
        <li>
            <a href="/namespace/{{$namespace->longname}}">
                {{  $namespace->longname }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
