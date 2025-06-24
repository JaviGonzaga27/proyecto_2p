<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ValidarStoreProducto;
use App\Http\Requests\ValidarEditProducto;

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
        // Crea el producto con los datos validados
        Producto::create($request->validated());

        // Redirecciona con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
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
        $producto->update($request->validated());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }
}
