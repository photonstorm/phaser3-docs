@extends('layouts.app')
@section('title', 'Physics')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h2>
                    Scenes Section.
                </h2>
                <ul>

                    @foreach ($class_scene as $scene)
                    <li>
                        <a href="{{$scene->longname}}">{{$scene->name}}</a>
                    </li>
                    @endforeach

                    <br>

                    @foreach ($memberof_scenes as $memberof_scene)
                    <li>
                        <a href="{{$memberof_scene->longname}}">{{$memberof_scene->name}}</a>
                    </li>
                    @endforeach

                    <br>
                    <h3>Members</h3>
                    @foreach ($scene_members_class as $scene_member_class)
                    <li>
                        <a href="{{$scene_member_class->longname}}">{{$scene_member_class->name}}</a>
                    </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
@endsection
