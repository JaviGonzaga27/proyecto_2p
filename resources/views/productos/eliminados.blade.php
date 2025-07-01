@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-trash text-danger mr-2"></i>
                Productos Eliminados
            </h1>
            <p class="mb-0 text-gray-600">Gestiona los productos eliminados de tu inventario</p>
        </div>
        <div>
            <a href="{{ route('productos.auditoria') }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-history fa-sm text-white-50"></i> Auditoría
            </a>
            <a href="{{ route('productos.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Productos
            </a>
        </div>
    </div>

    <!-- Filtros y Opciones de Tabla -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter mr-2"></i>Filtros y Opciones
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('productos.eliminados') }}" id="tableOptionsForm">
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
                            <option value="deleted_at" {{ $tableOptions['sort_by'] == 'deleted_at' ? 'selected' : '' }}>
                                Fecha de eliminación
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
                            <a href="{{ route('productos.eliminados') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar filtros">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Información de resultados -->
    @if($search || $tableOptions['sort_by'] != 'deleted_at' || $tableOptions['sort_direction'] != 'desc')
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

    <!-- Tabla de Productos Eliminados -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fas fa-trash mr-2"></i>
                Productos Eliminados
                <span class="badge badge-danger ml-2">{{ $tableOptions['total_records'] }}</span>
            </h6>

            <!-- Información de paginación en el header -->
            <small class="text-muted">
                @if($tableOptions['total_records'] > 0)
                Página {{ $tableOptions['current_page'] }} de {{ $tableOptions['last_page'] }}
                @endif
            </small>
        </div>

        <div class="card-body p-0">
            @if ($productosEliminados->isEmpty())
            <div class="text-center py-5">
                <div class="text-gray-500">
                    <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                    <h5 class="text-gray-600">
                        @if($search)
                        No se encontraron productos eliminados
                        @else
                        ¡Excelente!
                        @endif
                    </h5>
                    @if(!$search)
                    <p class="text-gray-500">No tienes productos eliminados en este momento.</p>
                    @endif
                    <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-boxes mr-1"></i> Ver Productos Activos
                    </a>
                </div>
            </div>
            @else
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
                            <th class="text-center">Stock</th>
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
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'deleted_at', 'sort_direction' => $tableOptions['sort_by'] == 'deleted_at' && $tableOptions['sort_direction'] == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Eliminado el
                                    @if($tableOptions['sort_by'] == 'deleted_at')
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
                        @foreach ($productosEliminados as $producto)
                        <tr class="text-muted">
                            <td class="font-weight-bold">#{{ $producto->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-initial bg-danger text-white rounded-circle">
                                            {{ strtoupper(substr($producto->nombre, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-danger">{{ $producto->nombre }}</div>
                                        <small class="text-muted">Producto eliminado</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $producto->codigo }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light" style="font-size: 15px;">
                                    {{ $producto->cantidad }}
                                    unidad{{ $producto->cantidad != 1 ? 'es' : '' }}
                                </span>
                            </td>
                            <td>
                                <div class="font-weight-bold">
                                    ${{ number_format($producto->precio, 2) }}
                                </div>
                            </td>
                            <td>
                                <div class="text-danger small font-weight-bold">
                                    {{ $producto->deleted_at->format('d/m/Y') }}
                                </div>
                                <div class="text-muted small">
                                    {{ $producto->deleted_at->format('H:i') }}
                                </div>
                                <div class="text-muted small">
                                    {{ $producto->deleted_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="text-center">
                                <!-- Botones de acción -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-success"
                                        data-toggle="modal"
                                        data-target="#confirmarRestaurarModal{{ $producto->id }}"
                                        title="Restaurar producto">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        data-toggle="modal"
                                        data-target="#confirmarEliminarModal{{ $producto->id }}"
                                        title="Eliminar permanentemente">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>

                                <!-- Modal de Confirmación para Restaurar -->
                                <div class="modal fade" id="confirmarRestaurarModal{{ $producto->id }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="modalRestaurarLabel{{ $producto->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title"
                                                    id="modalRestaurarLabel{{ $producto->id }}">
                                                    <i class="fas fa-undo mr-2"></i>
                                                    Restaurar Producto
                                                </h5>
                                                <button type="button" class="close text-white"
                                                    data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-success" role="alert">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Este producto volverá a estar disponible en tu
                                                    inventario.
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="font-weight-bold text-gray-800">Producto
                                                        a restaurar:</h6>
                                                    <div class="card bg-light">
                                                        <div class="card-body py-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <strong>Nombre:</strong>
                                                                    {{ $producto->nombre }}<br>
                                                                    <strong>Código:</strong> <span
                                                                        class="badge badge-secondary">{{ $producto->codigo }}</span><br>
                                                                    <strong>Stock:</strong>
                                                                    {{ $producto->cantidad }}
                                                                    unidades<br>
                                                                    <strong>Precio:</strong>
                                                                    ${{ number_format($producto->precio, 2) }}<br>
                                                                    <strong>Eliminado:</strong>
                                                                    {{ $producto->deleted_at->diffForHumans() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="razonRestauracion{{ $producto->id }}" class="form-label">
                                                        <strong>Razón de la restauración:</strong>
                                                    </label>
                                                    <textarea class="form-control" id="razonRestauracion{{ $producto->id }}" name="razon_restauracion" rows="3" placeholder="Describe la razón por la cual se restaura este producto...">Producto necesario para el inventario</textarea>
                                                </div>

                                                <p class="text-muted mb-0">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Una vez restaurado, el producto aparecerá nuevamente
                                                    en tu lista de productos activos.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Cancelar
                                                </button>
                                                <form
                                                    action="{{ route('productos.restore', $producto->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-undo mr-1"></i>
                                                        Restaurar Producto
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de Confirmación para Eliminación Permanente -->
                                <div class="modal fade"
                                    id="confirmarEliminarModal{{ $producto->id }}" tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="modalEliminarLabel{{ $producto->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title"
                                                    id="modalEliminarLabel{{ $producto->id }}">
                                                    <i class="fas fa-trash-alt mr-2"></i>
                                                    Eliminar Producto Permanentemente
                                                </h5>
                                                <button type="button" class="close text-white"
                                                    data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    Esta acción eliminará el producto de forma
                                                    definitiva y no se podrá recuperar.
                                                </div>
                                                <div class="mb-3">
                                                    <h6 class="font-weight-bold text-gray-800">Producto
                                                        a eliminar:</h6>
                                                    <div class="card bg-light">
                                                        <div class="card-body py-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <strong>Nombre:</strong>
                                                                    {{ $producto->nombre }}<br>
                                                                    <strong>Código:</strong> <span
                                                                        class="badge badge-secondary">{{ $producto->codigo }}</span><br>
                                                                    <strong>Stock:</strong>
                                                                    {{ $producto->cantidad }}
                                                                    unidades<br>
                                                                    <strong>Precio:</strong>
                                                                    ${{ number_format($producto->precio, 2) }}<br>
                                                                    <strong>Eliminado:</strong>
                                                                    {{ $producto->deleted_at->diffForHumans() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="razonEliminacion{{ $producto->id }}" class="form-label">
                                                        <strong>Razón de la eliminación permanente:</strong>
                                                    </label>
                                                    <textarea class="form-control" id="razonEliminacion{{ $producto->id }}" name="razon_eliminacion" rows="3" placeholder="Describe la razón por la cual se elimina permanentemente este producto..." required>Producto obsoleto o dañado</textarea>
                                                </div>

                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        value=""
                                                        id="aceptarCondiciones{{ $producto->id }}"
                                                        onchange="document.getElementById('btnEliminarDefinitivo{{ $producto->id }}').disabled = !this.checked;">
                                                    <label class="form-check-label text-danger"
                                                        for="aceptarCondiciones{{ $producto->id }}">
                                                        Acepto que este producto se eliminará
                                                        permanentemente y no podrá ser recuperado.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Cancelar
                                                </button>
                                                <form
                                                    action="{{ route('productos.forceDestroy', $producto->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        id="btnEliminarDefinitivo{{ $producto->id }}"
                                                        disabled>
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                        Eliminar Permanentemente
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Footer con paginación e información -->
        @if($productosEliminados->hasPages() || $tableOptions['total_records'] > 0)
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6">
                    @if($tableOptions['total_records'] > 0)
                    <div class="text-muted small">
                        <i class="fas fa-info-circle mr-1"></i>
                        Mostrando <strong>{{ $tableOptions['from'] }}</strong> a
                        <strong>{{ $tableOptions['to'] }}</strong> de
                        <strong>{{ $tableOptions['total_records'] }}</strong> productos eliminados
                        @if($search)
                        <span class="text-muted">(filtrados)</span>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-right">
                        {{ $productosEliminados->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Action Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Productos Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('productos.index') }}" class="text-decoration-none">
                                    Ver inventario principal
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

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
