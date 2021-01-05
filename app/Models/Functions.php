<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    public function params() {
        $paramsClass = $this->hasMany(Param::class, 'parentFunction', 'name')->where('parentClass', $this->memberof);
        $paramsNamespace = $this->hasMany(Param::class, 'parentClass', 'longname');
        $params = [];
        if(!empty($paramsClass)) {
            $params = $paramsClass;
        }
        if(!empty($paramsNamespace)) {
            $params = $paramsNamespace;
        }
        return $params;
    }
    // TODO: Remove if params function work fine for params namespace and params classes
    // public function paramsNamespace() {
    //     return $this->hasMany(Param::class, 'parentClass', 'longname');
    // }
}
