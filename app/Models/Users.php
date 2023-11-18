<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $connection = 'mysql';
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'apellidosP', 'apellidosM', 'fecha_nacimiento', 'dni', 'email', 'email_verified_at', 'telefono', 'tipo_usuario', 'foto_archivo', 'estado',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'userID');
    }

}
