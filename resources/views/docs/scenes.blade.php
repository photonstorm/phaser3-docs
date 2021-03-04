@extends('app')
@section('title', 'Physics')
@section('content')
<div class="container layout-container landing-page px-5">
    <div class="row">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 text-center my-4 border-bottom">
                    <h3>Scenes</h3>
                </div>

                <div class="mt-4">
                    <ul>
                        @foreach ($class_scene as $scene)
                        <li>
                            <a href="{{$scene->longname}}">{{$scene->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <ul>
                        @foreach ($memberof_scenes as $memberof_scene)
                        <li>
                            <a href="{{$memberof_scene->longname}}">{{$memberof_scene->name}}</a>
                        </li>
                        @endforeach
                    </ul>

                    <h3 class="mt-4">
                        <u>
                            Members
                        </u>
                    </h3>
                    <ul class="row">

                        @foreach ($scene_members_class as $scene_member_class)
                        <li>
                            <a
                                href="{{str_replace('-', '#', $scene_member_class->longname)}}">{{$scene_member_class->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
