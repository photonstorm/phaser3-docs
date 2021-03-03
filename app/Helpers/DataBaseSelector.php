<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DataBaseSelector {

    static function has(String $version) {
        $list_db = collect(self::getListDB());
        return $list_db->contains($version);
    }

    // Get list of DB directory
    static function getListDB() {
        $db_collection_list = collect(scandir("../".Config::get('app.database_route')));
        $db_list = $db_collection_list->filter( function($db) {
            return !(preg_match("/^[.]{0,2}$|.(gitignore)/i", $db));
        })->map(function($db) {
            return str_replace('.db', '', $db);
        })->sortDesc()->values();

        return $db_list->toArray();
    }

    // Get last DB from list
    static function getLastDB() {
        return self::getListDB()[0];
    }

    static function setDataBase($version) {
        Config::set('app.phaser_version', $version);
        Config::set('database.connections.sqlite.database', database_path("$version.db"));
        DB::purge('sqlite');
    }
}
