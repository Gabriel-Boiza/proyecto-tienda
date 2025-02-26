<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CategoriaController;


class Producto extends Model
{
    protected $fillable = [
        'nombre', 'precio', 'descripcion', 'stock', 'imagen_principal', 'descuento', 'fk_marca'
    ];
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'productos_categorias', 'id_producto', 'id_categoria');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'fk_marca');  
    }
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }
}
