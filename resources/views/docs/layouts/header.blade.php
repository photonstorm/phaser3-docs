@php
use App\Helpers\DataBaseSelector;
$version = Config::get('app.phaser_version');
@endphp

<header id="docs-header" class="w-100 mb-5 d-flex flex-column">
    {{-- Include menu Phaser original --}}
    @include('menu')
    <div class="container pt-4">
        <h1 class="text-white" style="font-weight: bold">Phaser API Documentation</h1>
        <div>
            <strong class="text-white h2">version: </strong><span id="react-change-version-selector"
                data-db_list="{{ json_encode(DataBaseSelector::getListDB()) }}"></span>
        </div>
    </div>
    @include('docs.layouts.menu-docs', ['some' => json_encode(["uno" => "carauno", "dos" => "caraods"])])
</header>
