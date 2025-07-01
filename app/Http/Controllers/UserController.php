<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ValidarStoreUser;
use App\Http\Requests\ValidarEditUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PaginationTrait;

class UserController extends Controller
{
    use PaginationTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener parámetros validados usando el trait
        $params = $this->getPaginationParams($request, 'users');

        // Construir la consulta
        $query = User::select('id', 'name', 'email', 'created_at', 'updated_at', 'email_verified_at');

        // Aplicar filtros de búsqueda
        if (!empty($params['search'])) {
            $searchTerm = '%' . $params['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('email', 'LIKE', $searchTerm);
            });
        }

        // Aplicar ordenamiento
        $query->orderBy($params['sort_by'], $params['sort_direction']);

        // Ejecutar consulta con paginación
        $usuarios = $query->paginate($params['per_page']);

        // Mantener parámetros en la paginación
        $usuarios->appends($request->query());

        // Preparar datos para la vista usando el trait
        $tableOptions = $this->getTableOptions($usuarios, $params);

        return view('users.index', compact('usuarios', 'tableOptions'))
            ->with('perPage', $params['per_page'])
            ->with('search', $params['search']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarStoreUser $request)
    {
        // Preparar los datos validados
        $validated = $request->validated();

        // Hash de la contraseña
        $validated['password'] = Hash::make($validated['password']);

        // Crear el usuario con los datos validados
        User::create($validated);

        // Redireccionar con mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return view('users.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        return view('users.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarEditUser $request, User $usuario)
    {
        // Obtener los datos validados
        $validated = $request->validated();

        // Si se proporciona una nueva contraseña, hacer hash
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Si no se proporciona contraseña, no actualizarla
            unset($validated['password']);
        }

        // Manejar la verificación de email
        if ($request->has('toggle_verification')) {
            if ($request->boolean('toggle_verification')) {
                // Marcar como verificado si no lo está
                if (!$usuario->email_verified_at) {
                    $validated['email_verified_at'] = now();
                }
            } else {
                // Remover verificación si está marcado para remover
                $validated['email_verified_at'] = null;
            }
        }

        // Actualizar el usuario
        $usuario->update($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        // Verificar que no sea el usuario autenticado
        if (Auth::id() === $usuario->id) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propio usuario');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    /**
     * Verificar el email del usuario manualmente
     */
    public function verify(User $usuario)
    {
        if ($usuario->email_verified_at) {
            return redirect()->route('usuarios.show', $usuario)->with('info', 'El usuario ya está verificado');
        }

        $usuario->markEmailAsVerified();

        return redirect()->route('usuarios.show', $usuario)->with('success', 'Usuario verificado correctamente');
    }
}
