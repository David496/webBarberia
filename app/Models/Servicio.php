<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $connection = 'mysql';
    protected $table = 'servicio';
    public $timestamps = true;
    protected $primaryKey = 'servicioID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->servicioID;
    }
}
