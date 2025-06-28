<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ValidarStoreProducto;
use App\Http\Requests\ValidarEditProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditoriaService;
use App\Models\AuditoriaProducto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validar el parámetro per_page
    $perPage = $request->get('per_page', 10);

    // Validar que sea numérico y esté dentro de los valores permitidos
    if (!is_numeric($perPage) || !in_array($perPage, [10, 25, 50])) {
        $perPage = 10; // Valor por defecto
    }

    // Convertir a entero para mayor seguridad
    $perPage = (int) $perPage;

    // Obtener término de búsqueda
    $search = $request->get('search');

    // Construir la consulta
    $query = Producto::select('id', 'nombre', 'codigo', 'cantidad', 'precio', 'created_at', 'updated_at');

    // Aplicar filtros de búsqueda si existe el término
    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $query->where(function($q) use ($searchTerm) {
            $q->where('nombre', 'LIKE', $searchTerm)
              ->orWhere('codigo', 'LIKE', $searchTerm);
        });
    }

    // Ejecutar la consulta con paginación
    $productos = $query->paginate($perPage);

    // Mantener los parámetros de consulta en la paginación
    $productos->appends($request->query());

    return view('productos.index', compact('productos', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarStoreProducto $request)
    {
        DB::beginTransaction();

        try {
            // Crear el producto
            $producto = Producto::create($request->validated());

            // Registrar auditoría de creación
            AuditoriaService::registrarCreacion($producto, 'Producto creado desde el formulario');

            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el producto: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarEditProducto $request, Producto $producto)
    {
        // Guardar datos anteriores para auditoría
        $datosAnteriores = $producto->toArray();

        $producto->update($request->validated());

        // Registrar auditoría de actualización
        AuditoriaService::registrarActualizacion($producto, $datosAnteriores, 'Producto actualizado desde el formulario de edición');

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Producto $producto)
    {
        // Validar la razón si se proporciona
        $request->validate([
            'razon' => 'nullable|string|max:500'
        ]);

        // Capturar la razón desde el request o usar mensaje por defecto
        $razon = $request->input('razon', 'Producto eliminado desde el listado principal');

        // Si hay razón del usuario, agregar contexto
        if ($request->filled('razon')) {
            $razon = 'Eliminación desde índice - Razón: ' . $request->input('razon');
        }

        // Registrar auditoría antes de eliminar
        AuditoriaService::registrarEliminacion(
            $producto,
            $razon
        );

        $producto->delete(); // Esto solo marca como eliminado (soft delete)
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }

    /**
     * Display a listing of the deleted products.
     */
    public function eliminados() {
        $productosEliminados = Producto::onlyTrashed()->get();
        return view('productos.eliminados', compact('productosEliminados'));
    }

    /**
     * Restore a deleted product.
     */
    public function restore(Request $request, $id)
    {
        $producto = Producto::onlyTrashed()->findOrFail($id);

        // Obtener la razón de la restauración del request
        $razon = $request->input('razon_restauracion', 'Producto restaurado desde la lista de eliminados');

        // Registrar auditoría antes de restaurar
        AuditoriaService::registrarRestauracion($producto, $razon);

        $producto->restore();
        return redirect()->route('productos.index')->with('success', 'Producto restaurado correctamente');
    }

    /**
     * Permanently remove a deleted product from storage.
     */
    public function forceDestroy(Request $request, $id)
    {
        $producto = Producto::onlyTrashed()->findOrFail($id);

        // Obtener la razón de la eliminación permanente del request
        $razon = $request->input('razon_eliminacion', 'Producto eliminado permanentemente desde la lista de eliminados');

        // Registrar auditoría antes de eliminar permanentemente
        AuditoriaService::registrarEliminacionPermanente($producto, $razon);

        $producto->forceDelete();
        return redirect()->route('productos.eliminados')->with('success', 'Producto eliminado permanentemente');
    }

    /**
     * Display audit history for products.
     */
    public function auditoria()
    {
        $auditorias = AuditoriaProducto::with(['usuario', 'producto'])
            ->orderBy('fecha_evento', 'desc')
            ->paginate(20);

        return view('productos.auditoria', compact('auditorias'));
    }
}
