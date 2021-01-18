<div class="aside ml-3">
    <h4 class="title">
        {{$title}}
    </h4>

    <div class="content">
        @if(!empty($namespaces) AND count($namespaces))
            <h5>
                Namespace
            </h5>
            <ul>
                @foreach ($namespaces as $namespace)
                    <li>
                        <a href="#{{$namespace->name}}">{{$namespace->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif
        @if(!empty($classes) AND count($classes))
            <h5>
                Classes
            </h5>
            <ul>
                @foreach ($classes as $class)
                    <li>
                        <a href="#{{$class->name}}">{{$class->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif
        @if(!empty($members) AND count($members))
            <h5>
                Members
            </h5>
            <ul>
                @foreach ($membersConstants as $member)
                    <li>
                        <a href="#{{$member->name}}">{{$member->name}}</a>
                    </li>
                @endforeach
                @foreach ($members as $member)
                    <li>
                        <a href="#{{$member->name}}">{{$member->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if(!empty($methods) AND count($methods))
            <h5>
                Methods
            </h5>
            <ul>
                @foreach ($methods as $method)
                    <li>
                        <a href="#{{$method->name}}">{{$method->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if(!empty($typedefs) AND count($typedefs))
            <h5>
                Type Definitions
            </h5>
            <ul>
                @foreach ($typedefs as $typedef)
                    <li>
                        <a href="#{{$typedef->name}}">{{$typedef->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if(!empty($events) AND count($events))
            <h5>
                Events
            </h5>
            <ul>
                @foreach ($events as $event)
                    <li>
                        <a href="#{{$event->name}}">{{$event->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>


</div>
