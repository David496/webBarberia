<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $connection = 'mysql';
    protected $table = 'reserva';
    public $timestamps = true;
    protected $primaryKey = 'reservaID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->reservaID;
    }

    public function usuario()
    {
        return $this->belongsTo('App\User','userID');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente','clienteID');
    }
}
