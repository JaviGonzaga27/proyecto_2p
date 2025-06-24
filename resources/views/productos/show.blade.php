@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Detalle del Producto</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('productos.index') }}" class="text-primary">Productos</a>
                        </li>
                        <li class="breadcrumb-item active text-gray-600" aria-current="page">
                            {{ $producto->nombre }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('productos.edit', $producto) }}"
                   class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Editar Producto
                </a>
                <a href="{{ route('productos.index') }}"
                   class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
                </a>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Información Principal -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Información del Producto</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Acciones:</div>
                                <a class="dropdown-item" href="{{ route('productos.edit', $producto) }}">
                                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Editar Producto
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">
                                    <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Eliminar Producto
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Nombre del Producto
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $producto->nombre }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Código del Producto
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span class="badge badge-light">{{ $producto->codigo }}</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-barcode fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="border-left-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }} shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }} text-uppercase mb-1">
                                                    Stock Disponible
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $producto->cantidad }} unidad{{ $producto->cantidad != 1 ? 'es' : '' }}
                                                </div>
                                                @if($producto->cantidad <= 10)
                                                    <div class="small text-{{ $producto->cantidad > 0 ? 'warning' : 'danger' }}">
                                                        @if($producto->cantidad == 0)
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>Sin stock
                                                        @else
                                                            <i class="fas fa-exclamation-circle mr-1"></i>Stock bajo
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Precio Unitario
                                                </div>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                                    ${{ number_format($producto->precio, 2) }}
                                                </div>
                                                <div class="small text-gray-600">
                                                    Valor total: ${{ number_format($producto->precio * $producto->cantidad, 2) }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="col-xl-4 col-lg-5">
                <!-- Información de Fechas -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Información de Registro</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="small font-weight-bold text-gray-800 mb-1">Fecha de Creación</div>
                            <div class="text-gray-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $producto->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-gray-500 small">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $producto->created_at->format('H:i') }}
                            </div>
                        </div>

                        @if($producto->updated_at && $producto->updated_at != $producto->created_at)
                            <div class="mb-3">
                                <div class="small font-weight-bold text-gray-800 mb-1">Última Actualización</div>
                                <div class="text-gray-600">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $producto->updated_at->format('d/m/Y') }}
                                </div>
                                <div class="text-gray-500 small">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $producto->updated_at->format('H:i') }}
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="text-center">
                            <span class="badge badge-primary">ID: #{{ $producto->id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Estado del Stock -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Estado del Inventario</h6>
                    </div>
                    <div class="card-body text-center">
                        @if($producto->cantidad > 10)
                            <div class="text-success mb-3">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                            <h6 class="text-success font-weight-bold">Stock Óptimo</h6>
                            <p class="text-gray-600 small mb-0">El producto cuenta con suficiente inventario</p>
                        @elseif($producto->cantidad > 0)
                            <div class="text-warning mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                            </div>
                            <h6 class="text-warning font-weight-bold">Stock Bajo</h6>
                            <p class="text-gray-600 small mb-0">Considera reabastecer pronto</p>
                        @else
                            <div class="text-danger mb-3">
                                <i class="fas fa-times-circle fa-3x"></i>
                            </div>
                            <h6 class="text-danger font-weight-bold">Sin Stock</h6>
                            <p class="text-gray-600 small mb-0">El producto no está disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-edit mr-2"></i> Editar Producto
                            </a>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-block mb-2">
                                <i class="fas fa-list mr-2"></i> Ver Todos los Productos
                            </a>
                            <button type="button" class="btn btn-danger btn-block" onclick="confirmDelete()">
                                <i class="fas fa-trash mr-2"></i> Eliminar Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Modal de Confirmación para Eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5>¿Está seguro que desea eliminar este producto?</h5>
                        <p class="text-gray-600">
                            Se eliminará permanentemente el producto <strong>"{{ $producto->nombre }}"</strong>
                        </p>
                        <p class="small text-danger">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            $('#deleteModal').modal('show');
        }
    </script>
@endsection
