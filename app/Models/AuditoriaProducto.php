<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Scope para incluir relaciones comunes
     */
    public function scopeWithRelations($query)
    {
        return $query->with(['usuario', 'producto']);
    }

    /**
     * Obtener el nombre del producto, incluso si está eliminado
     */
    public function getNombreProductoAttribute()
    {
        if ($this->producto) {
            return $this->producto->nombre;
        }

        // Si no existe el producto, intentar obtener el nombre de los datos guardados
        if ($this->datos_antes && isset($this->datos_antes['nombre'])) {
            return $this->datos_antes['nombre'];
        }

        if ($this->datos_despues && isset($this->datos_despues['nombre'])) {
            return $this->datos_despues['nombre'];
        }

        return 'Producto no disponible';
    }

    /**
     * Obtener el código del producto, incluso si está eliminado
     */
    public function getCodigoProductoAttribute()
    {
        if ($this->producto) {
            return $this->producto->codigo;
        }

        // Si no existe el producto, intentar obtener el código de los datos guardados
        if ($this->datos_antes && isset($this->datos_antes['codigo'])) {
            return $this->datos_antes['codigo'];
        }

        if ($this->datos_despues && isset($this->datos_despues['codigo'])) {
            return $this->datos_despues['codigo'];
        }

        return 'N/A';
    }
}
