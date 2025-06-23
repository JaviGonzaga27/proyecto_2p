@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">Detalle del Producto</h4>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nombre:</dt>
                <dd class="col-sm-9">{{ $producto->nombre }}</dd>

                <dt class="col-sm-3">Código:</dt>
                <dd class="col-sm-9">{{ $producto->codigo }}</dd>

                <dt class="col-sm-3">Cantidad:</dt>
                <dd class="col-sm-9">{{ $producto->cantidad }}</dd>

                <dt class="col-sm-3">Precio:</dt>
                <dd class="col-sm-9">${{ number_format($producto->precio, 2) }}</dd>

                <dt class="col-sm-3">Creado:</dt>
                <dd class="col-sm-9">{{ $producto->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection