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
        if( !$paramsClass->get()->isEmpty() ) {
            $params = $paramsClass;
        }
        if( !$paramsNamespace->get()->isEmpty() ) {
            $params = $paramsNamespace;
        }
        if(empty($params)) {
            return $params = $paramsClass;;
        }
        return $params;
    }

}
