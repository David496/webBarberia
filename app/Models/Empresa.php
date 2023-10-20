<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $connection = 'mysql';
    protected $table = 'empresa';
    public $timestamps = true;
    protected $primaryKey = 'empresaID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->empresaID;
    }
}
