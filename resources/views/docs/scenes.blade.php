@extends('app')
@section('title', 'Physics')


@section('content')
@include('docs.layouts.header')

<div class="container-fluid px-4 px-md-0">
    <div class="row">
        <div class="offset-0 offset-lg-1 offset-xl-3 col-12 col-lg-8 col-xl-6 order-2 order-md-1 layout-container landing-page px-4">
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
        <div class="col-12 col-lg-2 col-xl-3 mt-4 order-1 d-flex d-md-block justify-content-center">
            <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYI5KQN&placement=phaserio"
                id="_carbonads_js"></script>
        </div>
    </div>
</div>
@endsection
