<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
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
    $query = User::select('id', 'name', 'email', 'created_at', 'updated_at', 'email_verified_at');

    // Aplicar filtros de búsqueda si existe el término
    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'LIKE', $searchTerm)
              ->orWhere('email', 'LIKE', $searchTerm);
        });
    }

    // Ejecutar la consulta con paginación
    $usuarios = $query->paginate($perPage);

    // Mantener los parámetros de consulta en la paginación
    $usuarios->appends($request->query());

    return view('users.index', compact('usuarios', 'perPage'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
