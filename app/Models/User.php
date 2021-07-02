<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // agregar el softDelete, para usuarlo al momento de eliminar el usuario
    use SoftDeletes;

    // sse agrega para utlizar el softDelte
    protected $dates = ['deleted_at'];

    // los campos de nuestros modelos
    protected $fillable = [
        'usr_name',
        'usr_surname',
        'usr_role',
        'usr_estate',
        'usr_email',
        'usr_password',
        'usr_img',
    ];

     // los datos que no devolvera
     protected $hidden = [
        'usr_password',
        'usr_estate',
        'deleted_at',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relacion de uno a muschos a las categorias
    public function categories(){

        return $this->hasMany('App\Models\Category');
    }

    // relacion de uno a muchos a los post
    public function posts(){
        return $this->belongsTo('App\Models\Post');
    }
}
