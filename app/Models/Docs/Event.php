<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = "event";

    public function params()
    {
        return $this->hasMany(Param::class, "parentClass", "longname");
    }
}
