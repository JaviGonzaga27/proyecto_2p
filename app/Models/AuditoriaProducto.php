<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditoriaProducto extends Model
{
    protected $table = 'auditoria_productos';

    protected $fillable = [
        'producto_id',
        'accion',
        'razon',
        'user_id',
        'datos_antes',
        'datos_despues',
        'fecha_evento'
    ];

    protected $casts = [
        'datos_antes' => 'array',
        'datos_despues' => 'array',
        'fecha_evento' => 'datetime'
    ];

    /**
     * Relación con el usuario que realizó la acción
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el producto (incluyendo eliminados)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id')->withTrashed();
    }
}
