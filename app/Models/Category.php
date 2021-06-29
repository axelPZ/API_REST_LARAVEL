<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory;
    use SoftDeletes; // agregar el softDelete, para usuarlo al momento de eliminar el usuario

    protected $table ='categories';
    protected $dates = ['deleted_at'];// sse agrega para utlizar el softDelte


     // los datos que no devolvera
     protected $hidden = [
        'deleted_at',
        'remember_token',
    ];

     // los campos de nuestros modelos
     protected $fillable = [
        'cat_name',
        'cat_img',
        'cat_userId',
    ];

    // relacion de muchos a uno
    public function user()
    {
        return $this->belongsTo('App\Models\User','cat_userId');
    }
}
