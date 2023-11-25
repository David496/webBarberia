<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $connection = 'mysql';
    protected $table = 'reportes';
    public $timestamps = true;
    protected $primaryKey = 'rporteID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->rporteID;
    }
}
