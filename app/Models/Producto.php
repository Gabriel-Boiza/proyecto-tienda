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

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'productos_caracteristicas', 'id_producto', 'id_caracteristica');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'fk_marca');  
    }
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class, 'productos_pedidos', 'producto_id', 'pedido_id');
    }
}
