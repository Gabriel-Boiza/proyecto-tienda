<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CategoriaController;


class Producto extends Model
{
    protected $fillable = ['nombre'];

    public function categorias(){
        return $this->belongsToMany(Categoria::class, 'productos_categorias', 'id_categoria', 'id_producto' );
    }
}
