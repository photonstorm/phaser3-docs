<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';

    public function getTypedeftTypes() {
        return $this->hasMany(TypedefType::class, 'fk_id', 'longname');
    }

    public function getPhaserTypes() {
        return $this->hasMany(PhaserType::class, 'fk_id', 'longname');
    }

    public function getGlobalTypes() {
        return $this->hasMany(GlobalType::class, 'fk_id', 'longname');
    }
}
