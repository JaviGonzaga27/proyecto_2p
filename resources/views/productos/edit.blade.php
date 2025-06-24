@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit text-warning mr-2"></i>
                Editar Producto
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
                    <li class="breadcrumb-item active text-gray-600">
                        {{ Str::limit($producto->nombre, 30) }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm border shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Volver
            </a>
            <a href="{{ route('productos.show', $producto) }}" class="btn btn-info btn-sm shadow-sm">
                <i class="fas fa-eye fa-sm mr-1"></i> Ver
            </a>
        </div>
    </div>

    <!-- Información del Producto Actual -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-warning shadow-sm">
                <div class="card-body py-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Editando Producto
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $producto->nombre }}
                            </div>
                            <div class="text-xs text-muted mt-1">
                                Código: <strong>{{ $producto->codigo }}</strong> |
                                Creado: {{ $producto->created_at->format('d/m/Y H:i') }}
                                @if($producto->updated_at != $producto->created_at)
                                | Última modificación: {{ $producto->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-edit fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                Estado de Modificaciones
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" id="changeProgress"
                                     style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="text-xs text-gray-600">
                                <span id="changeText">Sin cambios</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">

            <form action="{{ route('productos.update', $producto) }}" method="POST" id="productoForm" novalidate>
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle text-primary mr-2"></i>
                                    Información Básica del Producto
                                </h6>
                                <small class="text-muted">Modifica los datos principales del producto</small>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" id="resetChanges"
                                            data-toggle="tooltip" title="Restaurar valores originales" disabled>
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info" id="compareChanges"
                                            data-toggle="tooltip" title="Ver cambios realizados" disabled>
                                        <i class="fas fa-exchange-alt"></i>
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
                                           value="{{ old('nombre', $producto->nombre) }}"
                                           maxlength="255"
                                           data-original="{{ $producto->nombre }}"
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
                                           value="{{ old('codigo', $producto->codigo) }}"
                                           maxlength="50"
                                           data-original="{{ $producto->codigo }}"
                                           data-field="required">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="button" id="generateCode"
                                                data-toggle="tooltip" title="Generar nuevo código">
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
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-success">
                                    <i class="fas fa-warehouse text-success mr-2"></i>
                                    Inventario y Precio
                                </h6>
                                <small class="text-muted">Actualiza las cantidades y precios del producto</small>
                            </div>
                            <div class="col-auto">
                                <div class="text-xs">
                                    <span class="badge badge-info">
                                        Valor Actual: ${{ number_format($producto->cantidad * $producto->precio, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
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
                                           value="{{ old('cantidad', $producto->cantidad) }}"
                                           min="0"
                                           max="999999"
                                           step="1"
                                           data-original="{{ $producto->cantidad }}"
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(-10)">-10</button>
                                                <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(-1)">-1</button>
                                                <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(1)">+1</button>
                                                <button type="button" class="btn btn-outline-info" onclick="adjustQuantity(10)">+10</button>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                Anterior: <strong class="text-info">{{ $producto->cantidad }}</strong>
                                            </small>
                                        </div>
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
                                           value="{{ old('precio', $producto->precio) }}"
                                           min="0"
                                           max="999999.99"
                                           step="0.01"
                                           data-original="{{ $producto->precio }}"
                                           data-field="required">
                                    @error('precio')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle text-info mr-1"></i>
                                        Precio anterior: <strong class="text-warning">${{ number_format($producto->precio, 2) }}</strong>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Comparación de Valores -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card border-left-secondary shadow-sm">
                                    <div class="card-body py-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                    <i class="fas fa-history text-secondary mr-1"></i>
                                                    Valor Actual del Inventario
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    ${{ number_format($producto->cantidad * $producto->precio, 2) }}
                                                </div>
                                                <div class="text-xs text-muted mt-1">
                                                    {{ $producto->cantidad }} unidades × ${{ number_format($producto->precio, 2) }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-archive fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-left-success shadow-sm">
                                    <div class="card-body py-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    <i class="fas fa-calculator text-success mr-1"></i>
                                                    Nuevo Valor del Inventario
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span id="valorTotal" class="text-success">$0.00</span>
                                                </div>
                                                <div class="text-xs text-muted mt-1">
                                                    <span id="calculoDetalle">0 unidades × $0.00</span>
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

                        <!-- Diferencia de Valor -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert" id="diferenciaAlert" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exchange-alt mr-2"></i>
                                        <span id="diferenciaTexto"></span>
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
                                    <i class="fas fa-shield-alt text-warning mr-2"></i>
                                    <div>
                                        <small class="text-muted font-weight-bold">
                                            Revisa todos los cambios antes de actualizar
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
                                            class="btn btn-warning btn-user shadow-sm"
                                            id="submitBtn"
                                            disabled>
                                        <i class="fas fa-save fa-sm mr-1"></i>
                                        <span id="submitText">Actualizar Producto</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productoForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const cancelBtn = document.getElementById('cancelBtn');
    const resetBtn = document.getElementById('resetChanges');
    const compareBtn = document.getElementById('compareChanges');

    // Inputs
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');
    const cantidadInput = document.getElementById('cantidad');
    const precioInput = document.getElementById('precio');

    // Display elements
    const valorTotalSpan = document.getElementById('valorTotal');
    const calculoDetalle = document.getElementById('calculoDetalle');
    const nombreCounter = document.getElementById('nombreCounter');
    const changeProgress = document.getElementById('changeProgress');
    const changeText = document.getElementById('changeText');
    const diferenciaAlert = document.getElementById('diferenciaAlert');
    const diferenciaTexto = document.getElementById('diferenciaTexto');
    const generateCodeBtn = document.getElementById('generateCode');

    // Valores originales
    const originalValues = {
        nombre: nombreInput.dataset.original,
        codigo: codigoInput.dataset.original,
        cantidad: parseFloat(cantidadInput.dataset.original),
        precio: parseFloat(precioInput.dataset.original)
    };

    const originalTotal = originalValues.cantidad * originalValues.precio;
    let hasChanges = false;

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Función para calcular valor total y diferencia
    function calcularValores() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio = parseFloat(precioInput.value) || 0;
        const total = cantidad * precio;
        const diferencia = total - originalTotal;

        valorTotalSpan.textContent = '$' + total.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        calculoDetalle.textContent = `${cantidad} unidades × $${precio.toFixed(2)}`;

        // Mostrar diferencia
        if (Math.abs(diferencia) > 0.01) {
            diferenciaAlert.style.display = 'block';
            if (diferencia > 0) {
                diferenciaAlert.className = 'alert alert-success';
                diferenciaTexto.innerHTML = `<strong>Incremento:</strong> +$${diferencia.toFixed(2)} en el valor total del inventario`;
            } else {
                diferenciaAlert.className = 'alert alert-warning';
                diferenciaTexto.innerHTML = `<strong>Reducción:</strong> -$${Math.abs(diferencia).toFixed(2)} en el valor total del inventario`;
            }
        } else {
            diferenciaAlert.style.display = 'none';
        }
    }

    // Función para detectar cambios
    function detectChanges() {
        const currentValues = {
            nombre: nombreInput.value.trim(),
            codigo: codigoInput.value.trim(),
            cantidad: parseFloat(cantidadInput.value) || 0,
            precio: parseFloat(precioInput.value) || 0
        };

        let changedFields = 0;
        let totalFields = Object.keys(originalValues).length;

        Object.keys(originalValues).forEach(key => {
            if (currentValues[key] != originalValues[key]) {
                changedFields++;
            }
        });

        hasChanges = changedFields > 0;

        // Actualizar barra de progreso
        const percentage = hasChanges ? (changedFields / totalFields) * 100 : 0;
        changeProgress.style.width = percentage + '%';
        changeProgress.setAttribute('aria-valuenow', percentage);

        if (hasChanges) {
            changeText.textContent = `${changedFields} campo${changedFields > 1 ? 's' : ''} modificado${changedFields > 1 ? 's' : ''}`;
            changeProgress.classList.remove('bg-success');
            changeProgress.classList.add('bg-warning');
        } else {
            changeText.textContent = 'Sin cambios';
            changeProgress.classList.remove('bg-warning');
            changeProgress.classList.add('bg-success');
        }

        // Habilitar/deshabilitar botones
        submitBtn.disabled = !hasChanges;
        resetBtn.disabled = !hasChanges;
        compareBtn.disabled = !hasChanges;
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
            detectChanges();
        }
    }

    // Función para resetear cambios
    function resetChanges() {
        if (confirm('¿Estás seguro de que quieres restaurar los valores originales?')) {
            nombreInput.value = originalValues.nombre;
            codigoInput.value = originalValues.codigo;
            cantidadInput.value = originalValues.cantidad;
            precioInput.value = originalValues.precio;

            updateNameCounter();
            calcularValores();
            detectChanges();
        }
    }

    // Función para mostrar comparación de cambios
    function showComparison() {
        let changes = [];

        if (nombreInput.value.trim() !== originalValues.nombre) {
            changes.push(`• Nombre: "${originalValues.nombre}" → "${nombreInput.value.trim()}"`);
        }
        if (codigoInput.value.trim() !== originalValues.codigo) {
            changes.push(`• Código: "${originalValues.codigo}" → "${codigoInput.value.trim()}"`);
        }
        if (parseFloat(cantidadInput.value) !== originalValues.cantidad) {
            changes.push(`• Cantidad: ${originalValues.cantidad} → ${cantidadInput.value} unidades`);
        }
        if (parseFloat(precioInput.value) !== originalValues.precio) {
            changes.push(`• Precio: $${originalValues.precio} → $${precioInput.value}`);
        }

        if (changes.length > 0) {
            alert('Cambios realizados:\n\n' + changes.join('\n'));
        }
    }

    // Función para actualizar contador de nombre
    function updateNameCounter() {
        const length = nombreInput.value.length;
        nombreCounter.innerHTML = `<small class="text-muted">${length}/255</small>`;
    }

    // Función para ajustar cantidad
    window.adjustQuantity = function(amount) {
        const currentValue = parseInt(cantidadInput.value) || 0;
        const newValue = Math.max(0, currentValue + amount);
        cantidadInput.value = newValue;
        calcularValores();
        detectChanges();
    };

    // Event listeners
    nombreInput.addEventListener('input', function() {
        updateNameCounter();
        detectChanges();
    });

    codigoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9-_]/g, '');
        detectChanges();
    });

    cantidadInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        if (this.value > 999999) this.value = 999999;
        calcularValores();
        detectChanges();
    });

    precioInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        if (this.value > 999999.99) this.value = 999999.99;
        calcularValores();
        detectChanges();
    });

    generateCodeBtn.addEventListener('click', generateProductCode);
    resetBtn.addEventListener('click', resetChanges);
    compareBtn.addEventListener('click', showComparison);

    // Confirmación antes de salir
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges && !form.submitting) {
            e.preventDefault();
            e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
        }
    });

    // Confirmación en botón cancelar
    cancelBtn.addEventListener('click', function(e) {
        if (hasChanges) {
            if (!confirm('Tienes cambios sin guardar. ¿Estás seguro de que quieres cancelar?')) {
                e.preventDefault();
            }
        }
    });

    // Manejo del envío del formulario
    form.addEventListener('submit', function(e) {
        if (!hasChanges) {
            e.preventDefault();
            alert('No se han realizado cambios para actualizar.');
            return;
        }

        form.submitting = true;

        // Cambiar estado del botón
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm mr-1"></i>Actualizando...';

        // Deshabilitar otros botones
        cancelBtn.classList.add('disabled');
        cancelBtn.style.pointerEvents = 'none';
        resetBtn.disabled = true;
        compareBtn.disabled = true;
    });

    // Navegación con Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT' && !e.target.classList.contains('no-enter')) {
            e.preventDefault();
            const focusableElements = Array.from(form.querySelectorAll('input, button, select, textarea'));
            const currentIndex = focusableElements.indexOf(e.target);
            const nextIndex = (currentIndex + 1) % focusableElements.length;
            focusableElements[nextIndex].focus();
        }
    });
    // Inicializar valores al cargar
    calcularValores();
    detectChanges();
    updateNameCounter();
});
</script>
@endsection
