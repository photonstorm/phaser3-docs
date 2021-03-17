<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $primaryKey = 'parentClass';

    public function getTypedefTypes() {
        return $this->hasMany(TypedefType::class, 'fk_id', 'id');
    }

    public function getPhaserTypes() {
        return $this->hasMany(PhaserType::class, 'fk_id', 'id');
    }

    public function getGlobalTypes() {
        return $this->hasMany(GlobalType::class, 'fk_id', 'id');
    }

}
