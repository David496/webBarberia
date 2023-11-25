<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'mysql';
    protected $table = 'producto';
    public $timestamps = true;
    protected $primaryKey = 'productoID';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';

    public function getIdAttribute()
    {
        return $this->productoID;
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'productoID');
    }
}
