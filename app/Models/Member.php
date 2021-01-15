<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function getTypedeftTypes() {
        return $this->hasMany(TypedefType::class, 'fk_id', 'longname');
    }

    public function getPhaserTypes() {
        return $this->hasMany(PhaserType::class, 'fk_id', 'longname');
    }

    public function getGlobalTypes() {
        return $this->hasMany(GlobalType::class, 'fk_id', 'longname');
    }

    public function getExamples() {
        return $this->hasMany(Example::class, 'fk_id', 'longname');
    }
}
