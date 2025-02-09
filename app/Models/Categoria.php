<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ProductoController;

class Categoria extends Model
{
    protected $fillable = ['nombre_categoria', 'categoria_padre'];
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'productos_categorias', 'id_categoria', 'id_producto');
    }
}
