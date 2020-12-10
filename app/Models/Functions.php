<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    public function params() {
        return $this->hasMany(Param::class, 'parentFunction', 'name')->where('parentClass', $this->memberof);
    }
}
