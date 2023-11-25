<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $connection = 'mysql';
    protected $table = 'venta';
    public $timestamps = true;
    protected $primaryKey = 'ventaID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->ventaID;
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'ventaID');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente','clienteID');
    }

}
