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
        <div class="d-none align-items-center ms-3 cursor-pointer" data-pushbar-target="pushbar-user-login-register">
            <img src="{{asset('images/user.png')}}" alt="User Logo">
        </div>
    </div>
</nav>

{{-- User data --}}
<div data-pushbar-id="pushbar-user-login-register" data-pushbar-direction="right" class="p-4">
    <h3>Login</h3>
    <form action="">
        <div>
            <input type="email" placeholder="Email" class="form-control w-100" aria-describedby="emailHelp" required>
        </div>
        <div class="mt-2">
            <input type="password" placeholder="Password" class="form-control w-100" required>
        </div>
        <div class="mt-3">
            <button class="btn btn-info w-100">Submit</button>
        </div>
        <div class="mt-1">
            <a href="">I can't remember my password</a>
        </div>
    </form>
    <button class="w-100 btn btn-danger text-white">
        <span class="vertical-middle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" class="v-icon__svg" style="font-size: 24px; height: 24px; width: 24px; fill:white;"><path d="M23,11H21V9H19V11H17V13H19V15H21V13H23M8,11V13.4H12C11.8,14.4 10.8,16.4 8,16.4C5.6,16.4 3.7,14.4 3.7,12C3.7,9.6 5.6,7.6 8,7.6C9.4,7.6 10.3,8.2 10.8,8.7L12.7,6.9C11.5,5.7 9.9,5 8,5C4.1,5 1,8.1 1,12C1,15.9 4.1,19 8,19C12,19 14.7,16.2 14.7,12.2C14.7,11.7 14.7,11.4 14.6,11H8Z"></path></svg>
        </span>
    </button>

    <hr>

    <a href="register">Register</a>
</div>
