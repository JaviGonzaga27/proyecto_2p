@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Registro de Auditoría - Productos</h1>
            <p class="mb-0 text-gray-600">Historial completo de todas las acciones realizadas en los productos</p>
        </div>
        <a href="{{ route('productos.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Productos
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history mr-2"></i>
                Historial de Auditoría
                @if($auditorias->total() > 0)
                <span class="badge badge-primary ml-2">{{ $auditorias->total() }}</span>
                @endif
            </h6>
        </div>
        <div class="card-body">
            @if($auditorias->isEmpty())
                <div class="text-center py-5">
                    <div class="text-gray-500">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5 class="text-gray-600">No hay registros de auditoría</h5>
                        <p class="text-gray-500">Los eventos de productos aparecerán aquí conforme se realicen acciones.</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Producto</th>
                                <th>Acción</th>
                                <th>Usuario</th>
                                <th>Razón</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditorias as $auditoria)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $auditoria->fecha_evento->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $auditoria->fecha_evento->format('H:i:s') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $auditoria->fecha_evento->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">
                                            @if($auditoria->producto)
                                                {{ $auditoria->producto->nombre }}
                                                <br>
                                                <span class="badge badge-secondary">{{ $auditoria->producto->codigo }}</span>
                                            @else
                                                <span class="text-muted">Producto eliminado permanentemente</span>
                                                <br>
                                                <small>ID: {{ $auditoria->producto_id }}</small>
                                            @endif
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
                                        <div class="font-weight-bold">{{ $auditoria->usuario->name }}</div>
                                        <small class="text-muted">{{ $auditoria->usuario->email }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $auditoria->razon ?: 'Sin razón especificada' }}</small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#detallesModal{{ $auditoria->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Modal de Detalles -->
                                        <div class="modal fade" id="detallesModal{{ $auditoria->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detalles de Auditoría</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6>Información General:</h6>
                                                        <ul>
                                                            <li><strong>Acción:</strong> {{ ucfirst($auditoria->accion) }}</li>
                                                            <li><strong>Fecha:</strong> {{ $auditoria->fecha_evento->format('d/m/Y H:i:s') }}</li>
                                                            <li><strong>Usuario:</strong> {{ $auditoria->usuario->name }}</li>
                                                            <li><strong>Razón:</strong> {{ $auditoria->razon ?: 'Sin razón especificada' }}</li>
                                                        </ul>

                                                        @if($auditoria->datos_antes)
                                                            <h6>Datos Anteriores:</h6>
                                                            <pre class="bg-light p-2">{{ json_encode($auditoria->datos_antes, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif

                                                        @if($auditoria->datos_despues)
                                                            <h6>Datos Posteriores:</h6>
                                                            <pre class="bg-light p-2">{{ json_encode($auditoria->datos_despues, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $auditorias->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
