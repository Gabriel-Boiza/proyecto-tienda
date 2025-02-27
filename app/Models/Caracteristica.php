<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $fillable = ['nombre'];
    protected $table = 'caracteristicas';
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'productos_caracteristicas', 'id_caracteristica', 'id_producto');
    }
}
