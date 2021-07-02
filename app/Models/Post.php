<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';
    protected $dates = ['deleted_at'];

    // los campos de nuestro modelo
    protected $fillable = [
        'pst_title',
        'pst_content',
        'pst_img'
    ];

    // los campos que no devolvemos
    protected $hidden = [
        'deleted_at',
        'pst_userId',
        'pst_cateId'
    ];

    // relacion de muchos a uno a la categoria
    public function category(){
        return $this->belongsTo('App\Models\Category', 'pst_cateId');
    }

    // relacion de muchos a uno al usuario
    public function post(){
        return $this->belongsTo('App\Models\User', 'pst_userId');
    }


}
