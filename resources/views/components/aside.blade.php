<div class="aside w-100 pt-4 pl-3" id="scrollspy_aside">
    <div class="content">
            <h5>Filter</h5>
            <div class="mb-3 form-group">
                <div class="ml-3">
                    <label class="align-middle" for="hide_inherited">Hide inherited members:</label>
                    <input type="checkbox" id="hide_inherited" />
                </div>
                <div class="ml-3">
                    <label class="align-middle" for="show_private_members">show private members:</label>
                    <input type="checkbox" id="show_private_members" />
                </div>
            </div>
        @if(!empty($namespaces) AND count($namespaces))
            <h5>
                Namespace
            </h5>
            <ul>
                @foreach ($namespaces as $namespace)
                    <li>
                        <a class="list-group-item" href="#{{$namespace->name}}">{{$namespace->name}}</a>
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
                        <a class="list-group-item" href="#{{$class->name}}">{{$class->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif
        @if((!empty($members) AND count($members)) OR (!empty($membersConstants) AND count($membersConstants)))
            <h5>
                Members
            </h5>
            <ul>
                @if(!empty($membersConstants) AND count($membersConstants))
                    @foreach ($membersConstants as $member)
                    <div class="{{ (!empty($member->inherits)) ? 'inherited' : '' }} {{ (!empty($membersConstants->access)) ? 'private' : '' }}">
                        <li>
                            <a class="list-group-item" href="#{{$member->name}}">{{$member->name}}</a>
                        </li>
                    </div>
                    @endforeach
                @endif
                @if((!empty($members) AND count($members)))
                    @foreach ($members as $member)
                        <div class="{{ (!empty($member->inherits)) ? 'inherited' : '' }} {{ (!empty($member->access)) ? 'private' : '' }}">
                            <li>
                                <a class="list-group-item" href="#{{$member->name}}">{{$member->name}}</a>
                            </li>
                        </div>
                    @endforeach
                @endif
            </ul>
        @endif

        @if(!empty($methods) AND count($methods))
            <h5>
                Methods
            </h5>
            <ul>
                @foreach ($methods as $method)
                    <div class="{{ (!empty($method->inherits)) ? 'inherited' : '' }} {{ (!empty($method->access)) ? 'private' : '' }}">
                        <li>
                            <a class="list-group-item" href="#{{$method->name}}">{{$method->name}}</a>
                        </li>
                    </div>
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
                        <a class="list-group-item" href="#{{$typedef->name}}">{{$typedef->name}}</a>
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
                        <a class="list-group-item" href="#{{$event->name}}">{{$event->name}}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
