@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-primary mr-2"></i>
                Nuevo Producto
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small bg-transparent p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-home fa-sm mr-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('productos.index') }}" class="text-decoration-none">
                            <i class="fas fa-boxes fa-sm mr-1"></i>Productos
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-gray-600">Nuevo</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm border shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Volver
            </a>
        </div>
    </div>

    <!-- Progress Indicator -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow-sm">
                <div class="card-body py-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Progreso del Formulario
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" role="progressbar" id="formProgress"
                                     style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="text-xs text-gray-600">
                                <span id="progressText">0/4 campos completados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">

            <form action="{{ route('productos.store') }}" method="POST" id="productoForm" novalidate>
                @csrf

                <!-- Información Básica -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle text-primary mr-2"></i>
                                    Información Básica del Producto
                                </h6>
                                <small class="text-muted">Complete los datos principales del producto</small>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown no-arrow">
                                    <button class="btn btn-light btn-sm dropdown-toggle border-0" type="button"
                                            data-toggle="tooltip" title="Todos los campos marcados con * son obligatorios">
                                        <i class="fas fa-question-circle text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Nombre del Producto -->
                            <div class="col-lg-8 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-tag text-primary mr-1"></i>
                                    Nombre del Producto <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white border-primary">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                           name="nombre"
                                           id="nombre"
                                           class="form-control form-control-lg border-left-0 @error('nombre') is-invalid @enderror"
                                           placeholder="Ej: Laptop Dell Inspiron 15"
                                           value="{{ old('nombre') }}"
                                           maxlength="255"
                                           data-field="required"
                                           autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light border-left-0" id="nombreCounter">
                                            <small class="text-muted">0/255</small>
                                        </span>
                                    </div>
                                    @error('nombre')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb text-warning mr-1"></i>
                                    Use un nombre descriptivo y único para identificar fácilmente el producto
                                </small>
                            </div>

                            <!-- Código del Producto -->
                            <div class="col-lg-4 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-barcode text-success mr-1"></i>
                                    Código <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white border-success">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                           name="codigo"
                                           id="codigo"
                                           class="form-control form-control-lg border-left-0 @error('codigo') is-invalid @enderror"
                                           placeholder="PROD-001"
                                           value="{{ old('codigo') }}"
                                           maxlength="50"
                                           data-field="required">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="button" id="generateCode"
                                                data-toggle="tooltip" title="Generar código automático">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                    </div>
                                    @error('codigo')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Código único del producto (alfanumérico)
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Inventario y Precio -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-warehouse text-success mr-2"></i>
                            Inventario y Precio
                        </h6>
                        <small class="text-muted">Configure las cantidades y precios del producto</small>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Cantidad en Stock -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-cubes text-info mr-1"></i>
                                    Cantidad en Stock <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white border-info">
                                            <i class="fas fa-cubes"></i>
                                        </span>
                                    </div>
                                    <input type="number"
                                           name="cantidad"
                                           id="cantidad"
                                           class="form-control border-left-0 @error('cantidad') is-invalid @enderror"
                                           placeholder="0"
                                           value="{{ old('cantidad') }}"
                                           min="0"
                                           max="999999"
                                           step="1"
                                           data-field="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light border-left-0">
                                            <strong class="text-info">unidades</strong>
                                        </span>
                                    </div>
                                    @error('cantidad')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(-10)">-10</button>
                                        <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(-1)">-1</button>
                                        <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(1)">+1</button>
                                        <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(10)">+10</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Precio Unitario -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-dollar-sign text-warning mr-1"></i>
                                    Precio Unitario <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white border-warning">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number"
                                           name="precio"
                                           id="precio"
                                           class="form-control border-left-0 @error('precio') is-invalid @enderror"
                                           placeholder="0.00"
                                           value="{{ old('precio') }}"
                                           min="0"
                                           max="999999.99"
                                           step="0.01"
                                           data-field="required">
                                    @error('precio')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle text-info mr-1"></i>
                                    Precio en dólares (USD)
                                </small>
                            </div>
                        </div>

                        <!-- Resumen de Cálculos -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-left-success shadow-sm">
                                    <div class="card-body py-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    <i class="fas fa-calculator text-success mr-1"></i>
                                                    Valor Total del Inventario
                                                </div>
                                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                                    <span id="valorTotal" class="text-success">$0.00</span>
                                                </div>
                                                <div class="text-xs text-muted mt-1">
                                                    <span id="calculoDetalle">0 unidades × $0.00 = $0.00</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="bg-success rounded-circle p-3">
                                                    <i class="fas fa-chart-line fa-2x text-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones del Formulario -->
                <div class="card shadow mb-4">
                    <div class="card-footer bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shield-alt text-success mr-2"></i>
                                    <div>
                                        <small class="text-muted font-weight-bold">
                                            Revisa todos los datos antes de guardar
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('productos.index') }}"
                                       class="btn btn-light btn-user border shadow-sm"
                                       id="cancelBtn">
                                        <i class="fas fa-times fa-sm mr-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit"
                                            class="btn btn-primary btn-user shadow-sm"
                                            id="submitBtn"
                                            disabled>
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
        @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Éxito:</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productoForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const cancelBtn = document.getElementById('cancelBtn');

    // Inputs
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');
    const cantidadInput = document.getElementById('cantidad');
    const precioInput = document.getElementById('precio');

    // Display elements
    const valorTotalSpan = document.getElementById('valorTotal');
    const calculoDetalle = document.getElementById('calculoDetalle');
    const nombreCounter = document.getElementById('nombreCounter');
    const progressBar = document.getElementById('formProgress');
    const progressText = document.getElementById('progressText');
    const generateCodeBtn = document.getElementById('generateCode');

    let formChanged = false;
    const requiredFields = document.querySelectorAll('[data-field="required"]');

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Función para calcular valor total
    function calcularValorTotal() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio = parseFloat(precioInput.value) || 0;
        const total = cantidad * precio;

        valorTotalSpan.textContent = '$' + total.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        calculoDetalle.textContent = `${cantidad} unidades × $${precio.toFixed(2)} = $${total.toFixed(2)}`;
    }

    // Función para actualizar el progreso del formulario
    function updateProgress() {
        let completedFields = 0;
        requiredFields.forEach(field => {
            if (field.value.trim() !== '') {
                completedFields++;
            }
        });

        const percentage = (completedFields / requiredFields.length) * 100;
        progressBar.style.width = percentage + '%';
        progressBar.setAttribute('aria-valuenow', percentage);
        progressText.textContent = `${completedFields}/${requiredFields.length} campos completados`;

        // Habilitar/deshabilitar botón de envío
        submitBtn.disabled = completedFields < requiredFields.length;

        if (completedFields === requiredFields.length) {
            progressBar.classList.remove('bg-primary');
            progressBar.classList.add('bg-success');
        } else {
            progressBar.classList.remove('bg-success');
            progressBar.classList.add('bg-primary');
        }
    }

    // Función para generar código automático
    function generateProductCode() {
        const nombre = nombreInput.value.trim();
        if (nombre) {
            const words = nombre.split(' ').filter(word => word.length > 0);
            let code = '';

            if (words.length >= 2) {
                code = words.slice(0, 2).map(word => word.charAt(0).toUpperCase()).join('');
            } else if (words.length === 1) {
                code = words[0].substring(0, 3).toUpperCase();
            }

            const timestamp = Date.now().toString().slice(-4);
            codigoInput.value = `${code}-${timestamp}`;
            formChanged = true;
            updateProgress();
        }
    }

    // Función para ajustar cantidad
    window.adjustQuantity = function(amount) {
        const currentValue = parseInt(cantidadInput.value) || 0;
        const newValue = Math.max(0, currentValue + amount);
        cantidadInput.value = newValue;
        calcularValorTotal();
        updateProgress();
        formChanged = true;
    };

    // Event listeners
    nombreInput.addEventListener('input', function() {
        const length = this.value.length;
        nombreCounter.innerHTML = `<small class="text-muted">${length}/255</small>`;
        formChanged = true;
        updateProgress();
    });

    codigoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9-_]/g, '');
        formChanged = true;
        updateProgress();
    });

    cantidadInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        if (this.value > 999999) this.value = 999999;
        calcularValorTotal();
        formChanged = true;
        updateProgress();
    });

    precioInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        if (this.value > 999999.99) this.value = 999999.99;
        calcularValorTotal();
        formChanged = true;
        updateProgress();
    });

    generateCodeBtn.addEventListener('click', generateProductCode);

    // Confirmación antes de salir
    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !form.submitting) {
            e.preventDefault();
            e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
        }
    });

    // Confirmación en botón cancelar
    cancelBtn.addEventListener('click', function(e) {
        if (formChanged) {
            if (!confirm('Tienes cambios sin guardar. ¿Estás seguro de que quieres cancelar?')) {
                e.preventDefault();
            }
        }
    });

    // Manejo del envío del formulario
    form.addEventListener('submit', function(e) {
        form.submitting = true;
        formChanged = false;

        // Cambiar estado del botón
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm mr-1"></i>Guardando...';

        // Deshabilitar botón cancelar
        cancelBtn.classList.add('disabled');
        cancelBtn.style.pointerEvents = 'none';
    });

    // Navegación con Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'submit') {
            const inputs = Array.from(form.querySelectorAll('input[type="text"], input[type="number"]'));
            const currentIndex = inputs.indexOf(e.target);

            if (currentIndex < inputs.length - 1) {
                e.preventDefault();
                inputs[currentIndex + 1].focus();
            } else if (currentIndex === inputs.length - 1 && !submitBtn.disabled) {
                e.preventDefault();
                form.submit();
            }
        }
    });

    // Inicializar cálculos y progreso
    calcularValorTotal();
    updateProgress();
});
</script>

@endsection
