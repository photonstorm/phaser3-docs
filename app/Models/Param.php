<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $primaryKey = 'parentClass';
    use HasFactory;

    public function getTypedeftTypes() {
        return $this->hasMany(TypedefType::class, 'fk_id', 'id');
    }

    public function getPhaserTypes() {
        return $this->hasMany(PhaserType::class, 'fk_id', 'id');
    }

    public function getGlobalTypes() {
        return $this->hasMany(GlobalType::class, 'fk_id', 'id');
    }

}
