<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{
    protected $connection= 'mysql';
    protected $table = 'ubigeo_provincias';
    public $timestamps = false;
    protected $primaryKey = 'UB_PROVI_CODIGO';

    protected $casts=[
        'UB_PROVI_CODIGO'=>'string',
        'UB_PROVI_NAME'=>'string',
        'UB_DEPA_CODIGO'=>'string'
    ];

    public function getIdAttribute(){
        return $this->UB_PROVI_CODIGO;
    }
}
