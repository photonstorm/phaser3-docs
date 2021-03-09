@php
use App\Helpers\DataBaseSelector;
$version = Config::get('app.phaser_version');
@endphp

<header id="docs-header" class="w-100 d-flex flex-column">
    {{-- Include menu Phaser original --}}
    @include('menu')
    <div class="container py-4">
        <h1 class="text-white" style="font-weight: bold">Phaser API Documentation</h1>

        <div class="row">
            <div class="col-12 col-md-4">
                <div id="react-searchbar" data-phaser_version={{ Config::get('app.phaser_version') }}></div>
            </div>
            <div class="col-12 col-md-3 d-flex align-items-center">
                &nbsp;&nbsp;<span class="text-white">Version:&nbsp;</span>
                <div>
                    <span id="react-change-version-selector"
                        data-db_list="{{ json_encode(DataBaseSelector::getListDB()) }}"></span>
                </div>
            </div>
        </div>


    </div>

    @include('docs.layouts.menu-docs', ['some' => json_encode(["uno" => "carauno", "dos" => "caraods"])])
</header>
