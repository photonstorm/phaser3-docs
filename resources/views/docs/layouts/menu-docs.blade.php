<nav class="menu-docs d-flex justify-content-center py-1 mt-3">
    <div class="menu-item mx-2 text-center {{ (request()->is(Config::get('app.phaser_version').'/namespaces') OR (Config::get('app.actual_link') === 'namespaces')) ? 'menu-active' : '' }} menu-active">
        <a href="{{route('docs.namespaces', ['version' => $version])}}">
            Namespaces
        </a>
    </div>
    <div class="menu-item mx-2 {{ (request()->is(Config::get('app.phaser_version').'/classes') OR (Config::get('app.actual_link') === 'classes')) ? 'menu-active' : '' }} text-center">
        <a href="{{route('docs.classes', ['version' => $version])}}">
            Classes
        </a>
    </div>
    <div class="menu-item mx-2 text-center {{ (request()->is(Config::get('app.phaser_version').'/events') OR (Config::get('app.actual_link') === 'events')) ? 'menu-active' : '' }}">
        <a href="{{route('docs.events', ['version' => $version])}}">
            Events
        </a>
    </div>
    <div class="menu-item mx-2 text-center {{ (request()->is(Config::get('app.phaser_version').'/gameobjects')) ? 'menu-active' : '' }}">
        <a href="{{route('docs.gameobjects', ['version' => $version])}}">
            Game Objects
        </a>
    </div>
    <div class="menu-item mx-2 text-center {{ (request()->is(Config::get('app.phaser_version').'/physics')) ? 'menu-active' : '' }}">
        <a href="{{route('docs.physics', ['version' => $version])}}">
            Physics
        </a>
    </div>
    <div class="menu-item mx-2 text-center {{ (request()->is(Config::get('app.phaser_version').'/scenes')) ? 'menu-active' : '' }}">
        <a href="{{route('docs.scenes', ['version' => $version])}}">
            Scenes
        </a>
    </div>
</nav>
