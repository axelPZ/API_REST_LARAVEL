<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    // agregar el softDelete, para usuarlo al momento de eliminar el usuario
    use SoftDeletes;

    protected $table = 'roles';

    // los datos que no devolvera
    protected $hidden = [
        'id',
        'updated_at',
        'created_at',
        'deleted_at',
        'remember_token',
    ];
}
