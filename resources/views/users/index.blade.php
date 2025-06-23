@extends('layouts.app')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-dark fw-bold">Usuarios</h1>
                    <p class="text-muted mb-0">Administra los usuarios del sistema</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('usuarios.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Buscar usuarios..."
                                   value="{{ request('search') }}"
                                   autocomplete="off">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                        </div>
                        @if(request('search'))
                            <a href="{{ route('usuarios.index') }}?per_page={{ $perPage }}"
                               class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Per Page Selector -->
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end align-items-center gap-2">
                        <label class="form-label mb-0 me-2 text-muted small">Mostrar:</label>
                        <select name="per_page"
                                id="per_page"
                                class="form-select form-select-sm w-auto"
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
    @if(request('search'))
        <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle text-info me-2"></i>
                <div>
                    <strong>{{ $usuarios->total() }}</strong> resultado(s) para
                    <strong>"{{ request('search') }}"</strong>
                </div>
            </div>
        </div>
    @endif

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 py-3 px-4 fw-semibold text-muted">ID</th>
                            <th class="border-0 py-3 fw-semibold text-muted">Usuario</th>
                            <th class="border-0 py-3 fw-semibold text-muted">Email</th>
                            <th class="border-0 py-3 fw-semibold text-muted">Estado</th>
                            <th class="border-0 py-3 fw-semibold text-muted">Registrado</th>
                            <th class="border-0 py-3 fw-semibold text-muted">Última Actividad</th>
                            <th class="border-0 py-3 fw-semibold text-muted text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $user)
                            <tr>
                                <td class="py-3 px-4 text-muted">#{{ $user->id }}</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td class="py-3">
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25">
                                            <i class="fas fa-check-circle me-1"></i> Verificado
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-white border border-warning border-opacity-25">
                                            <i class="fas fa-clock me-1"></i> Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-muted small">
                                    <div>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $user->created_at ? $user->created_at->format('H:i') : '' }}
                                    </div>
                                </td>
                                <td class="py-3 text-muted small">
                                    <div>{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'N/A' }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $user->updated_at ? $user->updated_at->format('H:i') : '' }}
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" style="margin-right: 10px" title="Ver perfil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning" style="margin-right: 10px" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3 text-muted opacity-50"></i>
                                        <p class="mb-0">
                                            @if(request('search'))
                                                No se encontraron usuarios para "{{ request('search') }}"
                                            @else
                                                No hay usuarios registrados
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
        @if($usuarios->hasPages() || $usuarios->total() > 0)
            <div class="card-footer bg-transparent border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        @if($usuarios->total() > 0)
                            <small class="text-muted">
                                Mostrando <strong>{{ $usuarios->firstItem() }}</strong> a
                                <strong>{{ $usuarios->lastItem() }}</strong> de
                                <strong>{{ $usuarios->total() }}</strong> usuarios
                                @if(request('search'))
                                    <span class="ms-1">(filtrados)</span>
                                @endif
                            </small>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end mt-2 mt-md-0">
                            {{ $usuarios->links() }}
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
