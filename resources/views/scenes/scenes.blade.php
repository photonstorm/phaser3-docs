@extends('layouts.app')
@section('title', 'Physics')
@section('content')
<div class="container layout-container landing-page px-4">
    <div class="row">
        <div class="col-12">
            <div class="mt-4">
                <h2>
                    <u>
                        Scenes Section.
                    </u>
                </h2>

                <div class="row">
                    @foreach ($class_scene as $scene)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{$scene->longname}}" class="btn-primary">{{$scene->name}}</a>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach ($memberof_scenes as $memberof_scene)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{$memberof_scene->longname}}" class="btn-primary">{{$memberof_scene->name}}</a>
                    </div>
                    @endforeach
                </div>

                <h3 class="mt-4">
                    <u>
                        Members
                    </u>
                </h3>
                <div class="row">

                    @foreach ($scene_members_class as $scene_member_class)
                    <div class="col-auto mt-2 btn btn-primary mx-1 d-flex justify-content-center">
                        <a href="{{str_replace('-', '#', $scene_member_class->longname)}}"
                            class="btn-primary">{{$scene_member_class->name}}</a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
