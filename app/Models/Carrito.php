<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    // Especificar la tabla si el nombre no sigue la convención
    protected $table = 'carritos';

    // Asegurarse de que estos campos son asignables
    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}

