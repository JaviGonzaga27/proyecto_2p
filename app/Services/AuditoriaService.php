<?php

namespace App\Services;

use App\Models\AuditoriaProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class AuditoriaService
{
    /**
     * Registrar un evento de auditoría
     */
    public static function registrarEvento(
        int $productoId,
        string $accion,
        string $razon = null,
        array $datosAntes = null,
        array $datosDespues = null
    ): AuditoriaProducto {
        return AuditoriaProducto::create([
            'producto_id' => $productoId,
            'accion' => $accion,
            'razon' => $razon,
            'user_id' => Auth::id(),
            'datos_antes' => $datosAntes,
            'datos_despues' => $datosDespues,
            'fecha_evento' => now()
        ]);
    }

    /**
     * Registrar eliminación de producto
     */
    public static function registrarEliminacion(Producto $producto, string $razon = null): AuditoriaProducto
    {
        return self::registrarEvento(
            $producto->id,
            'eliminado',
            $razon ?? 'Producto eliminado por el usuario',
            $producto->toArray(),
            null
        );
    }

    /**
     * Registrar restauración de producto
     */
    public static function registrarRestauracion(Producto $producto, string $razon = null): AuditoriaProducto
    {
        return self::registrarEvento(
            $producto->id,
            'restaurado',
            $razon ?? 'Producto restaurado por el usuario',
            null,
            $producto->toArray()
        );
    }

    /**
     * Registrar eliminación permanente
     */
    public static function registrarEliminacionPermanente(Producto $producto, string $razon = null): AuditoriaProducto
    {
        return self::registrarEvento(
            $producto->id,
            'eliminado_permanente',
            $razon ?? 'Producto eliminado permanentemente por el usuario',
            $producto->toArray(),
            null
        );
    }

    /**
     * Registrar creación de producto
     */
    public static function registrarCreacion(Producto $producto, string $razon = null): AuditoriaProducto
    {
        return self::registrarEvento(
            $producto->id,
            'creado',
            $razon ?? 'Producto creado por el usuario',
            null,
            $producto->toArray()
        );
    }

    /**
     * Registrar actualización de producto
     */
    public static function registrarActualizacion(Producto $producto, array $datosAnteriores, string $razon = null): AuditoriaProducto
    {
        return self::registrarEvento(
            $producto->id,
            'actualizado',
            $razon ?? 'Producto actualizado por el usuario',
            $datosAnteriores,
            $producto->toArray()
        );
    }
}
