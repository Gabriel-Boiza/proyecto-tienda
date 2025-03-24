<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'direccion',
        'ciudad',
        'codigo_postal',
        'pais',
    ];

    protected $hidden = [
        'password',  
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carritos', 'cliente_id', 'producto_id')
                    ->withPivot('cantidad'); // 'cantidad' es un campo extra en la tabla intermedia
    }
}
