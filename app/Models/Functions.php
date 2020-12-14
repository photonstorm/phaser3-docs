<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    public function paramsClass() {
        return $this->hasMany(Param::class, 'parentFunction', 'name')->where('parentClass', $this->memberof);
    }

    public function paramsNamespace() {
        return $this->hasMany(Param::class, 'parentClass', 'longname');
    }
}
