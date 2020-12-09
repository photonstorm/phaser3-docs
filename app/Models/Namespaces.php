<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Namespaces extends Model
{
    use HasFactory;

    protected $table = 'namespace';
    // protected $primaryKey = 'longname';

    // public function classes() {
    //     return $this->hasMany(Classes::class, 'memberof', 'longname');
    // }

    // public function namespaces() {
    //     return $this->hasMany(Namespaces::class, 'memberof');
    // }
}
