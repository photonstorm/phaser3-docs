@php
    use App\Helpers\DataBaseSelector;
@endphp

<nav class="menu d-flex justify-content-between align-items-center px-5">
    <div>
        <a href="/">
            <img src="{{asset('images/logo.png')}}" alt="Phaser Logo">
        </a>
    </div>
    <div class="d-flex">
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/namespaces') OR (Config::get('app.actual_link') === 'namespaces')) ? 'menu-active' : '' }}">
            <a href="/{{Config::get('app.phaser_version')}}/namespaces" class="text-white">
                Namespaces
            </a>
        </div>
        <div class="menu-item {{ (request()->is(Config::get('app.phaser_version').'/classes') OR (Config::get('app.actual_link') === 'classes')) ? 'menu-active' : '' }} text-center">
            <a href="/{{Config::get('app.phaser_version')}}/classes" class="text-white">
                Classes
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/events') OR (Config::get('app.actual_link') === 'events')) ? 'menu-active' : '' }}">
            <a href="/{{Config::get('app.phaser_version')}}/events" class="text-white">
                Events
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/gameobjects')) ? 'menu-active' : '' }}">
            <a href="/{{Config::get('app.phaser_version')}}/gameobjects" class="text-white">
                Game Objects
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/physics')) ? 'menu-active' : '' }}">
            <a href="/{{Config::get('app.phaser_version')}}/physics" class="text-white">
                Physics
            </a>
        </div>
        <div class="menu-item text-center {{ (request()->is(Config::get('app.phaser_version').'/scenes')) ? 'menu-active' : '' }}">
            <a href="/{{Config::get('app.phaser_version')}}/scenes" class="text-white">
                Scenes
            </a>
        </div>
        <div class="menu-version text-white d-flex align-items-center px-3">
            <div id="react-change-version-selector" data-db_list="{{ json_encode(DataBaseSelector::getListDB()) }}"></div>
        </div>
        <div class="d-flex align-items-center">
            <div id="react-searchbar" data-phaser_version={{ Config::get('app.phaser_version') }}></div>
        </div>
        <div class="d-flex align-items-center ms-3 cursor-pointer" data-pushbar-target="pushbar-user-login-register">
            <img src="{{asset('images/user.png')}}" alt="Phaser Logo">
        </div>
    </div>
</nav>

{{-- User data --}}
<div data-pushbar-id="pushbar-user-login-register" data-pushbar-direction="right">
    <h1>Login</h1>
    <a href="login">Login</a>
    <hr>
    <a href="register">Register</a>
</div>
