<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typedefs extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';

    public function properties() {
        return $this->hasMany(Property::class, 'parentType', 'longname');
    }

    public function params() {
        return $this->hasMany(Param::class, "parentFunction", "longname");
    }
}
