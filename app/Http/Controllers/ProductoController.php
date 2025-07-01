<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ValidarStoreProducto;
use App\Http\Requests\ValidarEditProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AuditoriaService;
use App\Models\AuditoriaProducto;
use App\Http\Traits\PaginationTrait;

class ProductoController extends Controller
{
    use PaginationTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener parámetros validados usando el trait
        $params = $this->getPaginationParams($request, 'productos');

        // Construir la consulta
        $query = Producto::select('id', 'nombre', 'codigo', 'cantidad', 'precio', 'created_at', 'updated_at');

        // Aplicar filtros de búsqueda
        if (!empty($params['search'])) {
            $searchTerm = '%' . $params['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', $searchTerm)
                    ->orWhere('codigo', 'LIKE', $searchTerm);
            });
        }

        // Aplicar ordenamiento
        $query->orderBy($params['sort_by'], $params['sort_direction']);

        // Ejecutar consulta con paginación
        $productos = $query->paginate($params['per_page']);

        // Mantener parámetros en la paginación
        $productos->appends($request->query());

        // Preparar datos para la vista usando el trait
        $tableOptions = $this->getTableOptions($productos, $params);

        return view('productos.index', compact('productos', 'tableOptions'))
            ->with('perPage', $params['per_page'])
            ->with('search', $params['search']);
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
    public function eliminados(Request $request)
    {
        // Obtener parámetros validados usando el trait
        $params = $this->getPaginationParams($request, 'productos_eliminados');

        // Construir la consulta para productos eliminados
        $query = Producto::onlyTrashed()
            ->select('id', 'nombre', 'codigo', 'cantidad', 'precio', 'created_at', 'updated_at', 'deleted_at');

        // Aplicar filtros de búsqueda
        if (!empty($params['search'])) {
            $searchTerm = '%' . $params['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', $searchTerm)
                    ->orWhere('codigo', 'LIKE', $searchTerm);
            });
        }

        // Aplicar ordenamiento (usar deleted_at como opción adicional)
        $sortBy = $params['sort_by'];
        if ($sortBy === 'created_at') {
            $sortBy = 'deleted_at'; // Para productos eliminados, mostrar por fecha de eliminación
        }
        $query->orderBy($sortBy, $params['sort_direction']);

        // Ejecutar consulta con paginación
        $productosEliminados = $query->paginate($params['per_page']);

        // Mantener parámetros en la paginación
        $productosEliminados->appends($request->query());

        // Preparar datos para la vista usando el trait
        $tableOptions = $this->getTableOptions($productosEliminados, $params);

        return view('productos.eliminados', compact('productosEliminados', 'tableOptions'))
            ->with('perPage', $params['per_page'])
            ->with('search', $params['search']);
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
    public function auditoria(Request $request)
    {
        // Obtener parámetros validados usando el trait
        $params = $this->getPaginationParams($request, 'auditoria');

        // Construir la consulta
        $query = AuditoriaProducto::with(['usuario', 'producto']);

        // Aplicar filtros de búsqueda
        if (!empty($params['search'])) {
            $searchTerm = '%' . $params['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('accion', 'LIKE', $searchTerm)
                    ->orWhere('razon', 'LIKE', $searchTerm)
                    ->orWhereHas('usuario', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'LIKE', $searchTerm)
                            ->orWhere('email', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('producto', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('nombre', 'LIKE', $searchTerm)
                            ->orWhere('codigo', 'LIKE', $searchTerm);
                    });
            });
        }

        // Filtro por acción
        $accion = $request->get('accion');
        if (!empty($accion)) {
            $query->where('accion', $accion);
        }

        // Aplicar ordenamiento
        $query->orderBy($params['sort_by'], $params['sort_direction']);

        // Ejecutar consulta con paginación
        $auditorias = $query->paginate($params['per_page']);

        // Mantener parámetros en la paginación
        $auditorias->appends($request->query());

        // Preparar datos para la vista usando el trait
        $tableOptions = $this->getTableOptions($auditorias, $params);

        return view('productos.auditoria', compact('auditorias', 'tableOptions'))
            ->with('perPage', $params['per_page'])
            ->with('search', $params['search'])
            ->with('accion', $accion);
    }
}
