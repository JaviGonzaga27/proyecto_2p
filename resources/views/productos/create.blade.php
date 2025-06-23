@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Nuevo Producto</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <!-- Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle text-primary mr-1"></i>
                        Información del Producto
                    </h6>
                    <div class="dropdown no-arrow">
                        <small class="text-muted">Todos los campos son obligatorios</small>
                    </div>
                </div>

                <form action="{{ route('productos.store') }}" method="POST" id="productoForm">
                    @csrf

                    <div class="card-body">
                        <div class="row">

                            <!-- Nombre del Producto -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-gray-700 font-weight-bold small">
                                    <i class="fas fa-tag text-primary mr-1"></i>
                                    Nombre del Producto
                                </label>
                                <input type="text"
                                       name="nombre"
                                       id="nombre"
                                       class="form-control form-control-user @error('nombre') is-invalid @enderror"
                                       placeholder="Ingrese el nombre del producto"
                                       value="{{ old('nombre') }}"
                                       autofocus>
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Código del Producto -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-gray-700 font-weight-bold small">
                                    <i class="fas fa-barcode text-primary mr-1"></i>
                                    Código del Producto
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-hashtag"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                           name="codigo"
                                           id="codigo"
                                           class="form-control @error('codigo') is-invalid @enderror"
                                           placeholder="Código único del producto"
                                           value="{{ old('codigo') }}">
                                    @error('codigo')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cantidad en Stock -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-gray-700 font-weight-bold small">
                                    <i class="fas fa-cubes text-primary mr-1"></i>
                                    Cantidad en Stock
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white">
                                            <i class="fas fa-box"></i>
                                        </span>
                                    </div>
                                    <input type="number"
                                           name="cantidad"
                                           id="cantidad"
                                           class="form-control @error('cantidad') is-invalid @enderror"
                                           placeholder="0"
                                           value="{{ old('cantidad') }}"
                                           min="0"
                                           step="1">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light text-gray-600">unidades</span>
                                    </div>
                                    @error('cantidad')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Precio Unitario -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label text-gray-700 font-weight-bold small">
                                    <i class="fas fa-dollar-sign text-primary mr-1"></i>
                                    Precio Unitario
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number"
                                           name="precio"
                                           id="precio"
                                           class="form-control @error('precio') is-invalid @enderror"
                                           placeholder="0.00"
                                           value="{{ old('precio') }}"
                                           min="0"
                                           step="0.01">
                                    @error('precio')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Información Adicional Card -->
                        <div class="card border-left-info shadow-sm mt-4">
                            <div class="card-body py-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Información del Sistema
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <span id="valorTotal">$0.00</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <small class="text-muted">Valor total del inventario para este producto</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Card Footer con Botones -->
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        <i class="fas fa-info-circle text-info mr-1"></i>
                                        Revisa todos los datos antes de guardar
                                    </div>
                                    <div>
                                        <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-user mr-2">
                                            <i class="fas fa-times fa-sm mr-1"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-user" id="submitBtn">
                                            <i class="fas fa-save fa-sm mr-1"></i>
                                            <span id="submitText">Guardar Producto</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productoForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const cantidadInput = document.getElementById('cantidad');
    const precioInput = document.getElementById('precio');
    const codigoInput = document.getElementById('codigo');
    const valorTotalSpan = document.getElementById('valorTotal');

    let formChanged = false;

    // Calcular valor total en tiempo real
    function calcularValorTotal() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio = parseFloat(precioInput.value) || 0;
        const total = cantidad * precio;
        valorTotalSpan.textContent = '$' + total.toFixed(2);
    }

    // Event listeners para cálculo automático
    cantidadInput.addEventListener('input', calcularValorTotal);
    precioInput.addEventListener('input', calcularValorTotal);

    // Validación en tiempo real para campos numéricos
    cantidadInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        formChanged = true;
    });

    precioInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        formChanged = true;
    });

    // Formatear código en mayúsculas y detectar cambios
    codigoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9-_]/g, '');
        formChanged = true;
    });

    // Detectar cambios en nombre
    document.getElementById('nombre').addEventListener('input', function() {
        formChanged = true;
    });

    // Confirmación antes de salir si hay cambios
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
        }
    });

    // Mejorar UX del formulario al enviar
    form.addEventListener('submit', function(e) {
        formChanged = false;

        // Deshabilitar botón y cambiar texto
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm mr-1"></i>Guardando...';

        // Validación final antes de enviar
        const nombre = document.getElementById('nombre').value.trim();
        const codigo = codigoInput.value.trim();
        const cantidad = cantidadInput.value;
        const precio = precioInput.value;

        if (!nombre || !codigo || !cantidad || !precio) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitText.innerHTML = '<i class="fas fa-save fa-sm mr-1"></i>Guardar Producto';

            // Mostrar toast de error (si tienes toasts configurados)
            // toastr.error('Por favor completa todos los campos requeridos');
        }
    });

    // Mejorar accesibilidad con Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
            const inputs = Array.from(form.querySelectorAll('input[type="text"], input[type="number"]'));
            const currentIndex = inputs.indexOf(e.target);

            if (currentIndex < inputs.length - 1) {
                e.preventDefault();
                inputs[currentIndex + 1].focus();
            }
        }
    });

    // Calcular valor inicial
    calcularValorTotal();
});
</script>

@endsection
