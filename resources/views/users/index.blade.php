@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users text-primary mr-2"></i>
                Usuarios
            </h1>
            <p class="mb-0 text-gray-600">Administra los usuarios del sistema</p>
        </div>
        <a href="{{ route('usuarios.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
        </a>
    </div>

    <!-- Filtros y Opciones de Tabla -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter mr-2"></i>Filtros y Opciones
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('usuarios.index') }}" id="tableOptionsForm">
                <div class="row">
                    <!-- Búsqueda -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label small font-weight-bold">Buscar</label>
                        <div class="input-group">
                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Nombre o email..."
                                value="{{ $search }}"
                                autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Registros por página -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label small font-weight-bold">Mostrar</label>
                        <select name="per_page" class="form-control" onchange="this.form.submit()">
                            @foreach($tableOptions['per_page_options'] as $option)
                            <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                                {{ $option }} registros
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordenar por -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label small font-weight-bold">Ordenar por</label>
                        <select name="sort_by" class="form-control" onchange="this.form.submit()">
                            <option value="created_at" {{ $tableOptions['sort_by'] == 'created_at' ? 'selected' : '' }}>
                                Fecha de registro
                            </option>
                            <option value="name" {{ $tableOptions['sort_by'] == 'name' ? 'selected' : '' }}>
                                Nombre
                            </option>
                            <option value="email" {{ $tableOptions['sort_by'] == 'email' ? 'selected' : '' }}>
                                Email
                            </option>
                            <option value="updated_at" {{ $tableOptions['sort_by'] == 'updated_at' ? 'selected' : '' }}>
                                Última actualización
                            </option>
                        </select>
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label small font-weight-bold">Dirección</label>
                        <select name="sort_direction" class="form-control" onchange="this.form.submit()">
                            <option value="asc" {{ $tableOptions['sort_direction'] == 'asc' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-up"></i> Ascendente
                            </option>
                            <option value="desc" {{ $tableOptions['sort_direction'] == 'desc' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-down"></i> Descendente
                            </option>
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="col-md-1 mb-3">
                        <label class="form-label small font-weight-bold">&nbsp;</label>
                        <div class="btn-group d-block">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar filtros">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Información de resultados -->
    @if($search || $tableOptions['sort_by'] != 'created_at' || $tableOptions['sort_direction'] != 'desc')
    <div class="alert alert-info alert-dismissible fade show">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>Filtros aplicados:</strong>
        @if($search)
        Búsqueda: "{{ $search }}" |
        @endif
        Ordenado por: {{ ucfirst(str_replace('_', ' ', $tableOptions['sort_by'])) }}
        ({{ $tableOptions['sort_direction'] == 'asc' ? 'Ascendente' : 'Descendente' }})
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <!-- Tabla de Usuarios -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Lista de Usuarios
                <span class="badge badge-primary ml-2">{{ $tableOptions['total_records'] }}</span>
            </h6>

            <!-- Información de paginación en el header -->
            <small class="text-muted">
                @if($tableOptions['total_records'] > 0)
                Página {{ $tableOptions['current_page'] }} de {{ $tableOptions['last_page'] }}
                @endif
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort_direction' => $tableOptions['sort_by'] == 'id' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    ID
                                    @if($tableOptions['sort_by'] == 'id')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => $tableOptions['sort_by'] == 'name' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Usuario
                                    @if($tableOptions['sort_by'] == 'name')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_direction' => $tableOptions['sort_by'] == 'email' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Email
                                    @if($tableOptions['sort_by'] == 'email')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Estado</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => $tableOptions['sort_by'] == 'created_at' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Fecha Registro
                                    @if($tableOptions['sort_by'] == 'created_at')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'updated_at', 'sort_direction' => $tableOptions['sort_by'] == 'updated_at' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Última Actividad
                                    @if($tableOptions['sort_by'] == 'updated_at')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                        <tr>
                            <td class="font-weight-bold">#{{ $usuario->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-initial bg-primary text-white rounded-circle">
                                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-primary">{{ $usuario->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $usuario->email }}</td>
                            <td class="text-center">
                                @if($usuario->email_verified_at)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle mr-1"></i>Verificado
                                </span>
                                @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock mr-1"></i>Pendiente
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ $usuario->created_at->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">{{ $usuario->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ $usuario->updated_at->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">{{ $usuario->updated_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('usuarios.show', $usuario) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger delete-btn"
                                        data-user-id="{{ $usuario->id }}"
                                        data-user-name="{{ $usuario->name }}"
                                        title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>
                                        @if($search)
                                        No se encontraron usuarios
                                        @else
                                        No hay usuarios registrados
                                        @endif
                                    </h5>
                                    @if(!$search)
                                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Crear Usuario
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer con paginación e información -->
        @if($usuarios->hasPages() || $tableOptions['total_records'] > 0)
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6">
                    @if($tableOptions['total_records'] > 0)
                    <div class="text-muted small">
                        Mostrando <strong>{{ $tableOptions['from'] }}</strong> a
                        <strong>{{ $tableOptions['to'] }}</strong> de
                        <strong>{{ $tableOptions['total_records'] }}</strong> usuarios
                        @if($search)
                        <span class="text-muted">(filtrados)</span>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-right">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

<!-- Modal de eliminación (sin cambios) -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog">
    <!-- ... contenido del modal sin cambios ... -->
</div>

<script>
    // Función para confirmar eliminación
    function confirmDelete(userId, userName) {
        document.getElementById('userName').textContent = userName;
        var url = '{{ route("usuarios.destroy", ":id") }}';
        url = url.replace(':id', userId);
        document.getElementById('deleteForm').action = url;
        $('#confirmarEliminarModal').modal('show');
    }

    // Event listeners para los botones de eliminar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                confirmDelete(userId, userName);
            });
        });
    });
</script>

<style>
    .avatar {
        width: 32px;
        height: 32px;
    }

    .avatar-initial {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
    }

    .table th a {
        color: inherit;
    }

    .table th a:hover {
        text-decoration: none !important;
        color: #007bff;
    }
</style>
@endsection
