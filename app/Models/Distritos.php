<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distritos extends Model
{
    protected $connection= 'mysql';
    protected $table = 'ubigeo_distritos';
    public $timestamps = false;
    protected $primaryKey = 'UB_DISTRI_CODIGO';

    protected $casts=[
        'UB_DISTRI_CODIGO'=>'string',
        'UB_DISTRI_NAME'=>'string',
        'UB_DEPA_CODIGO'=>'string',
        'UB_PROVI_CODIGO'=>'string'
    ];

    public function getIdAttribute(){
        return $this->UB_DISTRI_CODIGO;
    }
}
