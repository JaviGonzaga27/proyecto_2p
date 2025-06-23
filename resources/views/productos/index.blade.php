@extends('layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-dark fw-bold">Productos</h1>
                        <p class="text-muted mb-0">Gestiona el inventario de productos</p>
                    </div>
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i> Nuevo Producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row g-3 align-items-center">
                    <!-- Search -->
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('productos.index') }}" class="d-flex">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0"
                                    placeholder="Buscar productos..." value="{{ request('search') }}" autocomplete="off">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                            </div>
                            @if (request('search'))
                                <a href="{{ route('productos.index') }}?per_page={{ $perPage }}"
                                    class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Per Page Selector -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end align-items-center">
                            <label class="form-label mb-0 me-2 text-muted small">Mostrar:</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
                                onchange="changePerPage(this.value)">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Results Alert -->
        @if (request('search'))
            <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <div>
                        <strong>{{ $productos->total() }}</strong> resultado(s) para
                        <strong>"{{ request('search') }}"</strong>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted">ID</th>
                                <th class="border-0 py-3 fw-semibold text-muted">Producto</th>
                                <th class="border-0 py-3 fw-semibold text-muted">Código</th>
                                <th class="border-0 py-3 fw-semibold text-muted text-center">Cantidad</th>
                                <th class="border-0 py-3 fw-semibold text-muted text-end">Precio</th>
                                <th class="border-0 py-3 fw-semibold text-muted">Creado</th>
                                <th class="border-0 py-3 fw-semibold text-muted text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td class="py-3 px-4 text-muted">#{{ $producto->id }}</td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark">{{ $producto->nombre }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark border">{{ $producto->codigo }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span
                                            class="badge text-white {{ $producto->cantidad > 10 ? 'bg-success' : ($producto->cantidad > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $producto->cantidad }} unidad{{ $producto->cantidad != 1 ? 'es' : '' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-end fw-semibold">${{ number_format($producto->precio, 2) }}</td>
                                    <td class="py-3 text-muted small">
                                        {{ $producto->created_at ? $producto->created_at->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Botón Ver -->
                                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-outline-primary"
                                                style="margin-right: 10px" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Botón Editar -->
                                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-outline-warning"
                                                style="margin-right: 10px" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Botón Eliminar -->
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                                    onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center">
                                        <div class="text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3 text-muted opacity-50"></i>
                                            <p class="mb-0">
                                                @if (request('search'))
                                                    No se encontraron productos para "{{ request('search') }}"
                                                @else
                                                    No hay productos registrados
                                                @endif
                                            </p>
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
                <div class="card-footer bg-transparent border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            @if ($productos->total() > 0)
                                <small class="text-muted">
                                    Mostrando <strong>{{ $productos->firstItem() }}</strong> a
                                    <strong>{{ $productos->lastItem() }}</strong> de
                                    <strong>{{ $productos->total() }}</strong> productos
                                    @if (request('search'))
                                        <span class="ms-1">(filtrados)</span>
                                    @endif
                                </small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end mt-2 mt-md-0">
                                {{ $productos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function changePerPage(value) {
            if (!/^\d+$/.test(value)) {
                alert('Por favor, seleccione un valor válido.');
                return;
            }

            const allowedValues = ['10', '25', '50'];
            if (!allowedValues.includes(value)) {
                alert('Valor no permitido. Seleccione 10, 25 o 50.');
                return;
            }

            const url = new URL(window.location);
            url.searchParams.set('per_page', value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        document.getElementById('per_page').addEventListener('change', function() {
            const value = this.value;
            if (!/^\d+$/.test(value)) {
                this.value = '10';
                alert('Solo se permiten valores numéricos.');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.closest('form').submit();
                }
            });
        });
    </script>
@endsection
