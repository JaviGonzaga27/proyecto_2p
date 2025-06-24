@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Detalle del Usuario</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('usuarios.index') }}" class="text-primary">Usuarios</a>
                        </li>
                        <li class="breadcrumb-item active text-gray-600" aria-current="page">
                            {{ $usuario->name }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('usuarios.edit', $usuario) }}"
                   class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Editar Usuario
                </a>
                <a href="{{ route('usuarios.index') }}"
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
                        <h6 class="m-0 font-weight-bold text-primary">Información del Usuario</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Acciones:</div>
                                <a class="dropdown-item" href="{{ route('usuarios.edit', $usuario) }}">
                                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Editar Usuario
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">
                                    <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Eliminar Usuario
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
                                                    Nombre del Usuario
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $usuario->name }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                                    Correo Electrónico
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    {{ $usuario->email }}
                                                </div>
                                                <div class="small text-gray-600">
                                                    <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                                        <i class="fas fa-envelope mr-1"></i>Enviar correo
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="border-left-{{ $usuario->email_verified_at ? 'success' : 'warning' }} shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-{{ $usuario->email_verified_at ? 'success' : 'warning' }} text-uppercase mb-1">
                                                    Estado de Verificación
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    @if($usuario->email_verified_at)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle mr-1"></i>Email Verificado
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock mr-1"></i>Pendiente
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($usuario->email_verified_at)
                                                    <div class="small text-{{ $usuario->email_verified_at ? 'success' : 'warning' }}">
                                                        Verificado: {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                                                    </div>
                                                @else
                                                    <div class="small text-warning">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>Email no verificado
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-{{ $usuario->email_verified_at ? 'check-circle' : 'clock' }} fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="border-left-secondary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                    ID del Usuario
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    #{{ $usuario->id }}
                                                </div>
                                                <div class="small text-gray-600">
                                                    Identificador único en el sistema
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-hashtag fa-2x text-gray-300"></i>
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
                            <div class="small font-weight-bold text-gray-800 mb-1">Fecha de Registro</div>
                            <div class="text-gray-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $usuario->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-gray-500 small">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $usuario->created_at->format('H:i') }}
                            </div>
                        </div>

                        @if($usuario->updated_at && $usuario->updated_at != $usuario->created_at)
                            <div class="mb-3">
                                <div class="small font-weight-bold text-gray-800 mb-1">Última Actualización</div>
                                <div class="text-gray-600">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $usuario->updated_at->format('d/m/Y') }}
                                </div>
                                <div class="text-gray-500 small">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $usuario->updated_at->format('H:i') }}
                                </div>
                            </div>
                        @endif

                        @if($usuario->email_verified_at)
                            <div class="mb-3">
                                <div class="small font-weight-bold text-gray-800 mb-1">Email Verificado</div>
                                <div class="text-gray-600">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $usuario->email_verified_at->format('d/m/Y') }}
                                </div>
                                <div class="text-gray-500 small">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $usuario->email_verified_at->format('H:i') }}
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="text-center">
                            <span class="badge badge-primary">Registrado hace {{ $usuario->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Estado del Usuario -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Estado del Usuario</h6>
                    </div>
                    <div class="card-body text-center">
                        @if($usuario->email_verified_at)
                            <div class="text-success mb-3">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                            <h6 class="text-success font-weight-bold">Usuario Activo</h6>
                            <p class="text-gray-600 small mb-0">El usuario tiene acceso completo al sistema</p>
                        @else
                            <div class="text-warning mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                            </div>
                            <h6 class="text-warning font-weight-bold">Verificación Pendiente</h6>
                            <p class="text-gray-600 small mb-0">El usuario debe verificar su email para acceder completamente</p>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas del Usuario -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-6 text-center">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Días Registrado
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $usuario->created_at->diffInDays(now()) }}
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Estado
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    @if($usuario->email_verified_at)
                                        <span class="text-success">✓ Activo</span>
                                    @else
                                        <span class="text-warning">⏳ Pendiente</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-edit mr-2"></i> Editar Usuario
                            </a>
                            <a href="mailto:{{ $usuario->email }}" class="btn btn-info btn-block mb-2">
                                <i class="fas fa-envelope mr-2"></i> Enviar Email
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-block mb-2">
                                <i class="fas fa-list mr-2"></i> Ver Todos los Usuarios
                            </a>
                            @if(!$usuario->email_verified_at)
                                <button type="button" class="btn btn-success btn-block mb-2" onclick="confirmVerify()">
                                    <i class="fas fa-check mr-2"></i> Marcar como Verificado
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-block" onclick="confirmDelete()">
                                <i class="fas fa-trash mr-2"></i> Eliminar Usuario
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
                        <h5>¿Está seguro que desea eliminar este usuario?</h5>
                        <p class="text-gray-600">
                            Se eliminará permanentemente el usuario <strong>"{{ $usuario->name }}"</strong>
                        </p>
                        <p class="small text-danger">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display: inline;">
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

    <!-- Modal de Confirmación para Verificar -->
    @if(!$usuario->email_verified_at)
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Confirmar Verificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>¿Marcar este usuario como verificado?</h5>
                        <p class="text-gray-600">
                            El usuario <strong>"{{ $usuario->name }}"</strong> tendrá acceso completo al sistema
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('usuarios.verify', $usuario) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check mr-1"></i> Verificar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        function confirmDelete() {
            $('#deleteModal').modal('show');
        }

        function confirmVerify() {
            $('#verifyModal').modal('show');
        }
    </script>
@endsection
