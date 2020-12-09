@extends('layouts.app')
@section('content')
<div>
    <h3>Classes</h3>
    <ul>
        @foreach ($classes as $class)
        <li>
            <a href="/class/{{$class->longname}}">
                {{  $class->name }}
            </a>
        </li>
        @endforeach
    </ul>

    <h3>Namespace</h3>
    <ul>
        @foreach ($namespaces as $namespace)
        <li>
            <a href="/namespace/{{$namespace->longname}}">
                {{  $namespace->name }}
            </a>
        </li>
        @endforeach
    </ul>

</div>
@endsection
