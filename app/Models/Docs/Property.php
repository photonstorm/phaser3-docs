<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $primaryKey = "id";
    protected $keyType = 'string';

    public function getTypedefTypes()
    {
        return $this->hasMany(TypedefType::class, 'fk_id', 'id');
    }

    public function getPhaserTypes()
    {
        return $this->hasMany(PhaserType::class, 'fk_id', 'id');
    }

    public function getGlobalTypes()
    {
        return $this->hasMany(GlobalType::class, 'fk_id', 'id');
    }
}
