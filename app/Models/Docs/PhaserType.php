<?php

namespace App\Models\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaserType extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
}
