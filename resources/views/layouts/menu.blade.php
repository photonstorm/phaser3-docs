<nav class="menu d-flex justify-content-between align-items-center px-5 mb-4">
    <div class="d-flex">
        <div class="menu-item text-center px-3">
            <a href="/namespaces" class="text-white">
                Namespaces
            </a>
        </div>
        <div class="menu-item text-center px-3">
            <a href="/classes" class="text-white">
                Classes
            </a>
        </div>
        <div class="menu-item text-center px-3">
            <a href="/events" class="text-white">
                Events
            </a>
        </div>
        <div class="menu-version text-white d-flex align-items-center px-3">
            <select class="custom-select cursor-pointer" onchange='this.form.submit()'>
                <option selected>{{Config::get('app.phaser_version')}}</option>
                <option value="1">3.24.0</option>
            </select>
        </div>
    </div>
    <div>
        <a href="/">
            <img src="{{asset('images/logo.png')}}" alt="Phaser Logo">
        </a>
    </div>
</nav>
