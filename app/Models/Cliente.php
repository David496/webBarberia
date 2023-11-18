<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $connection = 'mysql';
    protected $table = 'cliente';
    public $timestamps = true;
    protected $primaryKey = 'clienteID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->clienteID;
    }

    public function getFullNameAttribute()
    {
        return $this->nombres . ' ' . $this->apellidoP . ' ' . $this->apellidoM;
    }

    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'clienteID');
    }
}
