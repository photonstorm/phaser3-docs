<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Docs\Changelog;

class ChangelogController extends Controller
{
    public function index() {

        $changelog = Changelog::get('page')->first();
        return view('docs.changelog', ["changelogPage" => $changelog->page]);
    }
}
