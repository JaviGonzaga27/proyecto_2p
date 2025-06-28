@extends('layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Productos</h1>
            <p class="mb-0 text-gray-600">Gestiona el inventario de productos de tu negocio</p>
        </div>
        <a href="{{ route('productos.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Producto
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12">

            <!-- Filters Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros de Búsqueda</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opciones:</div>
                            <a class="dropdown-item" href="{{ route('productos.index') }}">Limpiar filtros</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Search Form -->
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <form method="GET" action="{{ route('productos.index') }}" class="form-inline">
                                <div class="input-group w-100">
                                    <input type="text" name="search" class="form-control bg-light border-0 small"
                                        placeholder="Buscar productos por nombre o código..."
                                        value="{{ request('search') }}" autocomplete="off">
                                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Per Page Selector -->
                        <div class="col-lg-4">
                            <div class="form-group mb-0">
                                <label class="small text-gray-900 mr-2">Mostrar:</label>
                                <select name="per_page" id="per_page" class="form-control form-control-sm"
                                    onchange="changePerPage(this.value)" style="width: auto; display: inline-block;">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <span class="small text-gray-900 ml-1">registros</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results Alert -->
            @if (request('search'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>{{ $productos->total() }}</strong> resultado(s) encontrado(s) para
                <strong>"{{ request('search') }}"</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Clear Search -->
            @if (request('search'))
            <div class="mb-3">
                <a href="{{ route('productos.index') }}?per_page={{ $perPage }}"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times mr-1"></i> Limpiar búsqueda
                </a>
            </div>
            @endif

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Lista de Productos
                        @if ($productos->total() > 0)
                        <span class="badge badge-primary ml-2">{{ $productos->total() }}</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Código</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-right">Precio</th>
                                    <th>Fecha Creación</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productos as $producto)
                                <tr>
                                    <td class="text-gray-900 font-weight-bold">#{{ $producto->id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $producto->nombre }}</div>
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
                                    <td class="text-right font-weight-bold text-gray-900">
                                        ${{ number_format($producto->precio, 2) }}
                                    </td>
                                    <td class="text-gray-600 small">
                                        {{ $producto->created_at ? $producto->created_at->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Botón Ver -->
                                            <a href="{{ route('productos.show', $producto) }}"
                                                class="btn btn-sm btn-outline-primary mr-1" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Botón Editar -->
                                            <a href="{{ route('productos.edit', $producto) }}"
                                                class="btn btn-outline-warning btn-sm mr-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-outline-danger btn-sm mr-1" data-toggle="modal" data-target="#confirmarEliminarModal{{ $producto->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

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
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-gray-500">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <h5 class="text-gray-600">
                                                @if (request('search'))
                                                No se encontraron productos
                                                @else
                                                No hay productos registrados
                                                @endif
                                            </h5>
                                            <p class="text-gray-500">
                                                @if (request('search'))
                                                Intenta con otros términos de búsqueda
                                                @else
                                                Comienza creando tu primer producto
                                                @endif
                                            </p>
                                            @if (!request('search'))
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

                <!-- Pagination Footer -->
                @if ($productos->hasPages() || $productos->total() > 0)
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-5">
                            @if ($productos->total() > 0)
                            <div class="dataTables_info text-gray-700 small">
                                Mostrando <strong>{{ $productos->firstItem() }}</strong> a
                                <strong>{{ $productos->lastItem() }}</strong> de
                                <strong>{{ $productos->total() }}</strong> productos
                                @if (request('search'))
                                <span class="text-muted">(filtrados)</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers">
                                {{ $productos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
    function changePerPage(value) {
        // Validación del valor
        if (!/^\d+$/.test(value)) {
            alert('Por favor, seleccione un valor válido.');
            return;
        }

        const allowedValues = ['10', '25', '50'];
        if (!allowedValues.includes(value)) {
            alert('Valor no permitido. Seleccione 10, 25 o 50.');
            return;
        }

        // Construir nueva URL
        const url = new URL(window.location);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page'); // Reset page to 1
        window.location.href = url.toString();
    }

    // Validación del campo per_page
    document.getElementById('per_page').addEventListener('change', function() {
        const value = this.value;
        if (!/^\d+$/.test(value)) {
            this.value = '10';
            alert('Solo se permiten valores numéricos.');
        }
    });

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
