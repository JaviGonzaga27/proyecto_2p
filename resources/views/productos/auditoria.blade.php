@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-history text-primary mr-2"></i>
                Registro de Auditoría - Productos
            </h1>
            <p class="mb-0 text-gray-600">Historial completo de todas las acciones realizadas en los productos</p>
        </div>
        <a href="{{ route('productos.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Productos
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
            <form method="GET" action="{{ route('productos.auditoria') }}" id="tableOptionsForm">
                <div class="row">
                    <!-- Búsqueda -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label small font-weight-bold">Buscar</label>
                        <div class="input-group">
                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Producto, usuario, acción..."
                                value="{{ $search ?? '' }}"
                                autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filtro por Acción -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label small font-weight-bold">Acción</label>
                        <select name="accion" class="form-control" onchange="this.form.submit()">
                            <option value="">Todas las acciones</option>
                            <option value="creado" {{ ($accion ?? '') == 'creado' ? 'selected' : '' }}>Creado</option>
                            <option value="actualizado" {{ ($accion ?? '') == 'actualizado' ? 'selected' : '' }}>Actualizado</option>
                            <option value="eliminado" {{ ($accion ?? '') == 'eliminado' ? 'selected' : '' }}>Eliminado</option>
                            <option value="restaurado" {{ ($accion ?? '') == 'restaurado' ? 'selected' : '' }}>Restaurado</option>
                            <option value="eliminado_permanente" {{ ($accion ?? '') == 'eliminado_permanente' ? 'selected' : '' }}>Eliminado Permanente</option>
                        </select>
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
                            <option value="fecha_evento" {{ ($tableOptions['sort_by'] ?? 'fecha_evento') == 'fecha_evento' ? 'selected' : '' }}>
                                Fecha de evento
                            </option>
                            <option value="accion" {{ ($tableOptions['sort_by'] ?? '') == 'accion' ? 'selected' : '' }}>
                                Acción
                            </option>
                        </select>
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-1 mb-3">
                        <label class="form-label small font-weight-bold">Dirección</label>
                        <select name="sort_direction" class="form-control" onchange="this.form.submit()">
                            <option value="desc" {{ ($tableOptions['sort_direction'] ?? 'desc') == 'desc' ? 'selected' : '' }}>
                                Descendente
                            </option>
                            <option value="asc" {{ ($tableOptions['sort_direction'] ?? '') == 'asc' ? 'selected' : '' }}>
                                Ascendente
                            </option>
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="col-md-1 mb-3">
                        <label class="form-label small font-weight-bold">&nbsp;</label>
                        <div class="btn-group d-block">
                            <a href="{{ route('productos.auditoria') }}" class="btn btn-outline-secondary btn-sm" title="Limpiar filtros">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Información de resultados -->
    @if(($search ?? '') || ($accion ?? '') || ($tableOptions['sort_by'] ?? 'fecha_evento') != 'fecha_evento' || ($tableOptions['sort_direction'] ?? 'desc') != 'desc')
    <div class="alert alert-info alert-dismissible fade show">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>Filtros aplicados:</strong>
        @if($search ?? '')
        Búsqueda: "{{ $search }}" |
        @endif
        @if($accion ?? '')
        Acción: {{ ucfirst($accion) }} |
        @endif
        Ordenado por: {{ ucfirst(str_replace('_', ' ', $tableOptions['sort_by'] ?? 'fecha_evento')) }}
        ({{ ($tableOptions['sort_direction'] ?? 'desc') == 'asc' ? 'Ascendente' : 'Descendente' }})
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <!-- Tabla de Auditoría -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Historial de Auditoría
                <span class="badge badge-primary ml-2">{{ $tableOptions['total_records'] ?? $auditorias->total() }}</span>
            </h6>

            <!-- Información de paginación en el header -->
            <small class="text-muted">
                @if(($tableOptions['total_records'] ?? $auditorias->total()) > 0)
                Página {{ $tableOptions['current_page'] ?? $auditorias->currentPage() }} de {{ $tableOptions['last_page'] ?? $auditorias->lastPage() }}
                @endif
            </small>
        </div>

        <div class="card-body p-0">
            @if($auditorias->isEmpty())
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                    <h5>
                        @if($search ?? '')
                        No se encontraron registros de auditoría
                        @else
                        No hay registros de auditoría
                        @endif
                    </h5>
                    <p class="text-muted">Los eventos de productos aparecerán aquí conforme se realicen acciones.</p>
                </div>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'fecha_evento', 'sort_direction' => ($tableOptions['sort_by'] ?? 'fecha_evento') == 'fecha_evento' && ($tableOptions['sort_direction'] ?? 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="text-decoration-none text-dark">
                                    Fecha/Hora
                                    @if(($tableOptions['sort_by'] ?? 'fecha_evento') == 'fecha_evento')
                                    <i class="fas fa-sort-{{ ($tableOptions['sort_direction'] ?? 'desc') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Producto</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'accion', 'sort_direction' => ($tableOptions['sort_by'] ?? '') == 'accion' && ($tableOptions['sort_direction'] ?? 'desc') == 'asc' ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none text-dark">
                                    Acción
                                    @if(($tableOptions['sort_by'] ?? '') == 'accion')
                                    <i class="fas fa-sort-{{ ($tableOptions['sort_direction'] ?? 'desc') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                    <i class="fas fa-sort text-muted ml-1"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Usuario</th>
                            <th>Razón</th>
                            <th class="text-center">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auditorias as $auditoria)
                        <tr>
                            <td>
                                <div class="text-sm">
                                    <div class="font-weight-bold">{{ $auditoria->fecha_evento->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $auditoria->fecha_evento->format('H:i:s') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $auditoria->fecha_evento->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-initial bg-secondary text-white rounded-circle">
                                            <i class="fas fa-box fa-xs"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-primary">{{ $auditoria->nombre_producto }}</div>
                                        <small class="text-muted">{{ $auditoria->codigo_producto }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @switch($auditoria->accion)
                                @case('creado')
                                <span class="badge badge-success">
                                    <i class="fas fa-plus mr-1"></i>Creado
                                </span>
                                @break
                                @case('actualizado')
                                <span class="badge badge-warning">
                                    <i class="fas fa-edit mr-1"></i>Actualizado
                                </span>
                                @break
                                @case('eliminado')
                                <span class="badge badge-danger">
                                    <i class="fas fa-trash mr-1"></i>Eliminado
                                </span>
                                @break
                                @case('restaurado')
                                <span class="badge badge-info">
                                    <i class="fas fa-undo mr-1"></i>Restaurado
                                </span>
                                @break
                                @case('eliminado_permanente')
                                <span class="badge badge-dark">
                                    <i class="fas fa-trash-alt mr-1"></i>Eliminado Permanente
                                </span>
                                @break
                                @default
                                <span class="badge badge-secondary">{{ ucfirst($auditoria->accion) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-initial bg-primary text-white rounded-circle">
                                            {{ strtoupper(substr($auditoria->usuario->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-primary">{{ $auditoria->usuario->name }}</div>
                                        <small class="text-muted">{{ $auditoria->usuario->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $auditoria->razon ?: 'Sin razón especificada' }}</small>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-sm btn-outline-info"
                                    data-toggle="modal"
                                    data-target="#detallesModal{{ $auditoria->id }}"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Modal de Detalles -->
                                <div class="modal fade" id="detallesModal{{ $auditoria->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gradient-primary text-white">
                                                <h5 class="modal-title">
                                                    @switch($auditoria->accion)
                                                    @case('creado')
                                                    <i class="fas fa-plus-circle mr-2"></i>
                                                    Registro de Creación
                                                    @break
                                                    @case('actualizado')
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Registro de Actualización
                                                    @break
                                                    @case('eliminado')
                                                    <i class="fas fa-trash-alt mr-2"></i>
                                                    Registro de Eliminación
                                                    @break
                                                    @case('restaurado')
                                                    <i class="fas fa-undo mr-2"></i>
                                                    Registro de Restauración
                                                    @break
                                                    @case('eliminado_permanente')
                                                    <i class="fas fa-times-circle mr-2"></i>
                                                    Registro de Eliminación Permanente
                                                    @break
                                                    @default
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    Detalles de Auditoría
                                                    @endswitch
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <!-- Timeline Header -->
                                                <div class="timeline-header bg-light p-4 border-bottom">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-8">
                                                            <div class="d-flex align-items-center">
                                                                <div class="timeline-badge bg-primary text-white rounded-circle mr-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                    @switch($auditoria->accion)
                                                                    @case('creado')
                                                                    <i class="fas fa-plus"></i>
                                                                    @break
                                                                    @case('actualizado')
                                                                    <i class="fas fa-edit"></i>
                                                                    @break
                                                                    @case('eliminado')
                                                                    <i class="fas fa-trash"></i>
                                                                    @break
                                                                    @case('restaurado')
                                                                    <i class="fas fa-undo"></i>
                                                                    @break
                                                                    @case('eliminado_permanente')
                                                                    <i class="fas fa-times"></i>
                                                                    @break
                                                                    @default
                                                                    <i class="fas fa-info"></i>
                                                                    @endswitch
                                                                </div>
                                                                <div>
                                                                    <h5 class="mb-1 text-dark">{{ $auditoria->nombre_producto }}</h5>
                                                                    <p class="mb-0 text-muted">Código: {{ $auditoria->codigo_producto }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="timeline-date">
                                                                <div class="text-primary font-weight-bold">{{ $auditoria->fecha_evento->format('d/m/Y') }}</div>
                                                                <div class="text-muted">{{ $auditoria->fecha_evento->format('H:i:s') }}</div>
                                                                <small class="text-muted">{{ $auditoria->fecha_evento->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Main Content -->
                                                <div class="p-4">
                                                    <!-- Event Summary Card -->
                                                    <div class="card mb-4 border-left-primary">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary mb-3">
                                                                        <i class="fas fa-info-circle mr-2"></i>Información del Evento
                                                                    </h6>
                                                                    <div class="info-item mb-2">
                                                                        <span class="info-label">Acción Realizada:</span>
                                                                        @switch($auditoria->accion)
                                                                        @case('creado')
                                                                        <span class="badge badge-success ml-2">
                                                                            <i class="fas fa-plus mr-1"></i>Producto Creado
                                                                        </span>
                                                                        @break
                                                                        @case('actualizado')
                                                                        <span class="badge badge-warning ml-2">
                                                                            <i class="fas fa-edit mr-1"></i>Producto Actualizado
                                                                        </span>
                                                                        @break
                                                                        @case('eliminado')
                                                                        <span class="badge badge-danger ml-2">
                                                                            <i class="fas fa-trash mr-1"></i>Producto Eliminado
                                                                        </span>
                                                                        @break
                                                                        @case('restaurado')
                                                                        <span class="badge badge-info ml-2">
                                                                            <i class="fas fa-undo mr-1"></i>Producto Restaurado
                                                                        </span>
                                                                        @break
                                                                        @case('eliminado_permanente')
                                                                        <span class="badge badge-dark ml-2">
                                                                            <i class="fas fa-times mr-1"></i>Eliminado Permanentemente
                                                                        </span>
                                                                        @break
                                                                        @endswitch
                                                                    </div>
                                                                    <div class="info-item mb-2">
                                                                        <span class="info-label">Usuario Responsable:</span>
                                                                        <div class="d-inline-flex align-items-center ml-2">
                                                                            <div>
                                                                                <div class="font-weight-bold">{{ $auditoria->usuario->name }}</div>
                                                                                <small class="text-muted">{{ $auditoria->usuario->email }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if(!$auditoria->producto)
                                                                    <div class="alert alert-warning mt-3">
                                                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                                                        <strong>Producto eliminado permanentemente:</strong> Este producto ya no existe en el sistema.
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary mb-3">
                                                                        <i class="fas fa-comment-alt mr-2"></i>Motivo del Cambio
                                                                    </h6>
                                                                    <div class="reason-box p-3 bg-light rounded border">
                                                                        <p class="mb-0">
                                                                            @if($auditoria->razon)
                                                                            <i class="fas fa-quote-left text-muted mr-2"></i>
                                                                            {{ $auditoria->razon }}
                                                                            <i class="fas fa-quote-right text-muted ml-2"></i>
                                                                            @else
                                                                            <span class="text-muted">
                                                                                <i class="fas fa-info-circle mr-2"></i>
                                                                                No se especificó una razón para esta acción.
                                                                            </span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Data Comparison -->
                                                    @if($auditoria->datos_antes || $auditoria->datos_despues)
                                                    <div class="row">
                                                        @if($auditoria->datos_antes)
                                                        <div class="col-md-6">
                                                            <div class="card border-left-danger">
                                                                <div class="card-header bg-light">
                                                                    <h6 class="mb-0 text-danger">
                                                                        <i class="fas fa-arrow-left mr-2"></i>Datos Anteriores
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if(is_array($auditoria->datos_antes))
                                                                    <div class="data-display">
                                                                        @foreach($auditoria->datos_antes as $key => $value)
                                                                        @if(in_array($key, ['nombre', 'codigo', 'cantidad', 'precio']))
                                                                        <div class="data-row mb-2">
                                                                            <span class="data-key">{{ ucfirst($key) }}:</span>
                                                                            <span class="data-value">
                                                                                @if($key === 'precio')
                                                                                ${{ number_format($value, 2) }}
                                                                                @else
                                                                                {{ $value }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($auditoria->datos_despues)
                                                        <div class="col-md-6">
                                                            <div class="card border-left-success">
                                                                <div class="card-header bg-light">
                                                                    <h6 class="mb-0 text-success">
                                                                        <i class="fas fa-arrow-right mr-2"></i>Datos Posteriores
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if(is_array($auditoria->datos_despues))
                                                                    <div class="data-display">
                                                                        @foreach($auditoria->datos_despues as $key => $value)
                                                                        @if(in_array($key, ['nombre', 'codigo', 'cantidad', 'precio']))
                                                                        <div class="data-row mb-2">
                                                                            <span class="data-key">{{ ucfirst($key) }}:</span>
                                                                            <span class="data-value">
                                                                                @if($key === 'precio')
                                                                                ${{ number_format($value, 2) }}
                                                                                @else
                                                                                {{ $value }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-2"></i>Cerrar
                                                </button>
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
        @if($auditorias->hasPages() || ($tableOptions['total_records'] ?? $auditorias->total()) > 0)
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6">
                    @if(($tableOptions['total_records'] ?? $auditorias->total()) > 0)
                    <div class="text-muted small">
                        Mostrando <strong>{{ $tableOptions['from'] ?? $auditorias->firstItem() }}</strong> a
                        <strong>{{ $tableOptions['to'] ?? $auditorias->lastItem() }}</strong> de
                        <strong>{{ $tableOptions['total_records'] ?? $auditorias->total() }}</strong> registros
                        @if($search ?? '')
                        <span class="text-muted">(filtrados)</span>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-right">
                        {{ $auditorias->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
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

    pre code {
        font-size: 12px;
        max-height: 300px;
        overflow-y: auto;
    }
</style>
@endsection
