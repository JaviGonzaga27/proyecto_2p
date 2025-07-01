@extends('layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-boxes text-primary mr-2"></i>
                Productos
            </h1>
            <p class="mb-0 text-gray-600">Gestiona el inventario de productos de tu negocio</p>
        </div>
        <div>
            <a href="{{ route('productos.eliminados') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm mr-2">
                <i class="fas fa-trash fa-sm text-white-50"></i> Ver Eliminados
            </a>
            <a href="{{ route('productos.auditoria') }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-history fa-sm text-white-50"></i> Auditoría
            </a>
            <a href="{{ route('productos.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12">

    <!-- Filtros y Opciones de Tabla -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter mr-2"></i>Filtros y Opciones
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('productos.index') }}" id="tableOptionsForm">
                <div class="row">
                    <!-- Búsqueda -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label small font-weight-bold">Buscar</label>
                        <div class="input-group">
                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Nombre o código..."
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
                                Fecha de creación
                            </option>
                            <option value="nombre" {{ $tableOptions['sort_by'] == 'nombre' ? 'selected' : '' }}>
                                Nombre
                            </option>
                            <option value="codigo" {{ $tableOptions['sort_by'] == 'codigo' ? 'selected' : '' }}>
                                Código
                            </option>
                            <option value="precio" {{ $tableOptions['sort_by'] == 'precio' ? 'selected' : '' }}>
                                Precio
                            </option>
                            <option value="cantidad" {{ $tableOptions['sort_by'] == 'cantidad' ? 'selected' : '' }}>
                                Stock
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
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar filtros">
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

    <!-- Tabla de Productos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Lista de Productos
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
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nombre', 'sort_direction' => $tableOptions['sort_by'] == 'nombre' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Producto
                                    @if($tableOptions['sort_by'] == 'nombre')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'codigo', 'sort_direction' => $tableOptions['sort_by'] == 'codigo' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Código
                                    @if($tableOptions['sort_by'] == 'codigo')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'cantidad', 'sort_direction' => $tableOptions['sort_by'] == 'cantidad' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Stock
                                    @if($tableOptions['sort_by'] == 'cantidad')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'precio', 'sort_direction' => $tableOptions['sort_by'] == 'precio' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Precio
                                    @if($tableOptions['sort_by'] == 'precio')
                                    <i class="fas fa-sort-{{ $tableOptions['sort_direction'] == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => $tableOptions['sort_by'] == 'created_at' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Fecha Creación
                                    @if($tableOptions['sort_by'] == 'created_at')
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
                        @forelse ($productos as $producto)
                        <tr>
                            <td class="text-gray-900 font-weight-bold">#{{ $producto->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-initial bg-primary text-white rounded-circle">
                                            {{ strtoupper(substr($producto->nombre, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-primary">{{ $producto->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light">{{ $producto->codigo }}</span>
                            </td>
                            <td class="text-center">
                                @if($producto->cantidad > 10)
                                <span class="badge badge-success" style="font-size: 15px;">
                                    {{ $producto->cantidad }} unidad{{ $producto->cantidad != 1 ? 'es' : '' }}
                                </span>
                                @elseif($producto->cantidad > 0)
                                <span class="badge badge-warning" style="font-size: 15px;">
                                    {{ $producto->cantidad }} unidad{{ $producto->cantidad != 1 ? 'es' : '' }}
                                </span>
                                @else
                                <span class="badge badge-danger" style="font-size: 15px;">Sin stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold text-gray-900">
                                    ${{ number_format($producto->precio, 2) }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ $producto->created_at ? $producto->created_at->format('d/m/Y') : 'N/A' }}
                                    <br>
                                    <small class="text-muted">{{ $producto->created_at ? $producto->created_at->format('H:i') : '' }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Botón Ver -->
                                    <a href="{{ route('productos.show', $producto) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Botón Editar -->
                                    <a href="{{ route('productos.edit', $producto) }}"
                                        class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Botón Eliminar -->
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#confirmarEliminarModal{{ $producto->id }}"
                                            title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-gray-500">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <h5 class="text-gray-600">
                                        @if($search)
                                        No se encontraron productos
                                        @else
                                        No hay productos registrados
                                        @endif
                                    </h5>
                                    <p class="text-gray-500">
                                        @if($search)
                                        Intenta con otros términos de búsqueda
                                        @else
                                        Comienza creando tu primer producto
                                        @endif
                                    </p>
                                    @if(!$search)
                                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Crear Producto
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
        @if($productos->hasPages() || $tableOptions['total_records'] > 0)
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6">
                    @if($tableOptions['total_records'] > 0)
                    <div class="text-muted small">
                        <i class="fas fa-info-circle mr-1"></i>
                        Mostrando <strong>{{ $tableOptions['from'] }}</strong> a
                        <strong>{{ $tableOptions['to'] }}</strong> de
                        <strong>{{ $tableOptions['total_records'] }}</strong> productos
                        @if($search)
                        <span class="text-muted">(filtrados)</span>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-right">
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modales -->
    @foreach ($productos as $producto)
    <!-- Modal de Confirmación Eliminacion -->
    <div class="modal fade" id="confirmarEliminarModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $producto->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalLabel{{ $producto->id }}">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-gray-800">Producto a eliminar:</h6>
                        <div class="card bg-light">
                            <div class="card-body py-2">
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Nombre:</strong> {{ $producto->nombre }}<br>
                                        <strong>Código:</strong> <span class="badge badge-secondary">{{ $producto->codigo }}</span><br>
                                        <strong>Stock:</strong> {{ $producto->cantidad }} unidades<br>
                                        <strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigoConfirmacion{{ $producto->id }}" class="font-weight-bold text-gray-800">
                            Para confirmar, escribe el código del producto:
                            <span class="text-danger">{{ $producto->codigo }}</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="codigoConfirmacion{{ $producto->id }}"
                            placeholder="Escribe aquí: {{ $producto->codigo }}"
                            autocomplete="off">
                        <small class="form-text text-muted">
                            Esto ayuda a prevenir eliminaciones accidentales.
                        </small>
                    </div>

                    <!-- Campo para comentario/razón -->
                    <div class="form-group">
                        <label for="razonEliminacion{{ $producto->id }}" class="font-weight-bold text-gray-800">
                            Razón de eliminación <span class="text-muted">(opcional)</span>:
                        </label>
                        <textarea class="form-control"
                                  id="razonEliminacion{{ $producto->id }}"
                                  name="razon"
                                  rows="3"
                                  placeholder="Describe brevemente por qué eliminas este producto..."></textarea>
                        <small class="form-text text-muted">
                            Este comentario se guardará en el registro de auditoría.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Cancelar
                    </button>
                    <form method="POST" action="{{ route('productos.destroy', $producto) }}" id="formEliminar{{ $producto->id }}">
                        @csrf
                        @method('DELETE')
                        <!-- Campo oculto para la razón -->
                        <input type="hidden" name="razon" id="razonHidden{{ $producto->id }}">
                        <button type="submit"
                            class="btn btn-danger"
                            id="btnEliminar{{ $producto->id }}"
                            disabled>
                            <i class="fas fa-trash-alt mr-1"></i>
                            Eliminar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para validar el código antes de permitir eliminación
        document.getElementById('codigoConfirmacion{{ $producto->id }}').addEventListener('input', function() {
            const codigoIngresado = this.value.trim();
            const codigoRequerido = '{{ $producto->codigo }}';
            const btnEliminar = document.getElementById('btnEliminar{{ $producto->id }}');

            if (codigoIngresado === codigoRequerido) {
                btnEliminar.disabled = false;
                btnEliminar.classList.remove('btn-secondary');
                btnEliminar.classList.add('btn-danger');
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                btnEliminar.disabled = true;
                btnEliminar.classList.remove('btn-danger');
                btnEliminar.classList.add('btn-secondary');
                this.classList.remove('is-valid');
                if (codigoIngresado.length > 0) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            }
        });

        // Capturar la razón antes de enviar el formulario
        document.getElementById('formEliminar{{ $producto->id }}').addEventListener('submit', function() {
            const razon = document.getElementById('razonEliminacion{{ $producto->id }}').value;
            document.getElementById('razonHidden{{ $producto->id }}').value = razon;
        });

        // Limpiar el campo cuando se cierra el modal
        $('#confirmarEliminarModal{{ $producto->id }}').on('hidden.bs.modal', function () {
            const input = document.getElementById('codigoConfirmacion{{ $producto->id }}');
            const textarea = document.getElementById('razonEliminacion{{ $producto->id }}');
            const btn = document.getElementById('btnEliminar{{ $producto->id }}');

            input.value = '';
            textarea.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            btn.disabled = true;
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-secondary');
        });
    </script>
    @endforeach

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

<script>
    // Auto-submit en búsqueda al presionar Enter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');

        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.closest('form').submit();
                }
            });
        }
    });
</script>
@endsection
