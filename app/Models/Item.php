<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mysql';
    protected $table = 'item';
    public $timestamps = true;
    protected $primaryKey = 'itemID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->itemID;
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto','productoID');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio','servicioID');
    }

    public function venta()
    {
        return $this->belongsTo('App\Models\Venta','ventaID');
    }
}
