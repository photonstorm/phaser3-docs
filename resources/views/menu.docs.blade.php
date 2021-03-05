@php
    use App\Helpers\DataBaseSelector;
    $version = Config::get('app.phaser_version');
@endphp

<nav class="menu d-flex justify-content-between align-items-center px-5">
    <div>
        <a href="/">
            <img src="{{asset('images/logo.png')}}" alt="Phaser Logo">
        </a>
    </div>
    <div class="d-flex">
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/namespaces') OR (Config::get('app.actual_link') === 'namespaces')) ? 'menu-active' : '' }}">
            <a href="{{route('docs.namespaces', ['version' => $version])}}" class="text-white">
                Namespaces
            </a>
        </div>
        <div class="menu-item {{ (request()->is(Config::get('app.phaser_version').'/classes') OR (Config::get('app.actual_link') === 'classes')) ? 'menu-active' : '' }} text-center">
            <a href="{{route('docs.classes', ['version' => $version])}}" class="text-white">
                Classes
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/events') OR (Config::get('app.actual_link') === 'events')) ? 'menu-active' : '' }}">
            <a href="{{route('docs.events', ['version' => $version])}}" class="text-white">
                Events
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/gameobjects')) ? 'menu-active' : '' }}">
            <a href="{{route('docs.gameobjects', ['version' => $version])}}" class="text-white">
                Game Objects
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/physics')) ? 'menu-active' : '' }}">
            <a href="{{route('docs.physics', ['version' => $version])}}" class="text-white">
                Physics
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/scenes')) ? 'menu-active' : '' }}">
            <a href="{{route('docs.scenes', ['version' => $version])}}" class="text-white">
                Scenes
            </a>
        </div>
        <div class="menu-version text-white d-flex align-items-center px-3">
            <div id="react-change-version-selector" data-db_list="{{ json_encode(DataBaseSelector::getListDB()) }}"></div>
        </div>
        <div class="d-flex align-items-center">
            <div id="react-searchbar" data-phaser_version={{ Config::get('app.phaser_version') }}></div>
        </div>
    </div>
</nav>
