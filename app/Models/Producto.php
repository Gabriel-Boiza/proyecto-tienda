<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CategoriaController;


class Producto extends Model
{
    protected $fillable = [
        'nombre', 'precio', 'descripcion', 'stock', 'imagen_principal'
    ];
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'productos_categorias', 'id_producto', 'id_categoria');
    }
}
