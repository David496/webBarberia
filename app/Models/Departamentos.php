<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $connection= 'mysql';
    protected $table = 'ubigeo_departamentos';
    public $timestamps = false;
    protected $primaryKey = 'UB_DEPA_CODIGO';

    protected $casts=[
        'UB_DEPA_CODIGO'=>'string',
        'UB_DEPA_NAME'=>'string'
    ];


    public function getIdAttribute(){
        return $this->UB_DEPA_CODIGO;
    }
}
