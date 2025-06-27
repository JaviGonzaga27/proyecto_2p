@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Productos Eliminados</h1>
                <p class="mb-0 text-gray-600">Gestiona los productos eliminados de tu inventario</p>
            </div>
            <a href="{{ route('productos.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Productos
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12">

                <!-- Info Alert -->
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Información:</strong> Estos productos han sido eliminados pero pueden ser restaurados si es
                    necesario.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">
                            <i class="fas fa-trash mr-2"></i>
                            Productos Eliminados
                            @if ($productosEliminados->count() > 0)
                                <span class="badge badge-danger ml-2">{{ $productosEliminados->count() }}</span>
                            @endif
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($productosEliminados->isEmpty())
                            <div class="text-center py-5">
                                <div class="text-gray-500">
                                    <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                                    <h5 class="text-gray-600">¡Excelente!</h5>
                                    <p class="text-gray-500">No tienes productos eliminados en este momento.</p>
                                    <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-boxes mr-1"></i> Ver Productos Activos
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Código</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-right">Precio</th>
                                            <th>Eliminado el</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productosEliminados as $producto)
                                            <tr class="text-muted">
                                                <td class="font-weight-bold">#{{ $producto->id }}</td>
                                                <td>
                                                    <div class="font-weight-bold text-danger">{{ $producto->nombre }}</div>
                                                    <small class="text-muted">Producto eliminado</small>
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
                                                <td class="text-right font-weight-bold">
                                                    ${{ number_format($producto->precio, 2) }}
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
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#confirmarRestaurarModal{{ $producto->id }}"
                                                            title="Restaurar producto" style="margin-right: 5px;">
                                                            <i class="fas fa-undo mr-1"></i>
                                                            Restaurar
                                                        </button>
                                                        <br>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#confirmarEliminarModal{{ $producto->id }}"
                                                            title="Eliminar producto permanentemente">
                                                            <i class="fas fa-trash-alt mr-1"></i>
                                                            Eliminar
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

                    <!-- Footer con información adicional -->
                    @if ($productosEliminados->count() > 0)
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-md-6">
                                    <div class="text-gray-700 small">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Mostrando <strong>{{ $productosEliminados->count() }}</strong> producto(s)
                                        eliminado(s)
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right">
                                    <small class="text-muted">
                                        Los productos eliminados se conservan para posible restauración
                                    </small>
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
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
