<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $primaryKey = 'parentClass';
    use HasFactory;
}
