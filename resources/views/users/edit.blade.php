@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit text-warning mr-2"></i>
                Editar Usuario
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small bg-transparent p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-home fa-sm mr-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">
                            <i class="fas fa-users fa-sm mr-1"></i>Usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-gray-600">
                        {{ Str::limit($usuario->name, 30) }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('usuarios.index') }}" class="btn btn-light btn-sm border shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Volver
            </a>
            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info btn-sm shadow-sm">
                <i class="fas fa-eye fa-sm mr-1"></i> Ver
            </a>
        </div>
    </div>

    <!-- Información del Usuario Actual -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-warning shadow-sm">
                <div class="card-body py-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Editando Usuario
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $usuario->name }}
                            </div>
                            <div class="text-xs text-muted mt-1">
                                Email: <strong>{{ $usuario->email }}</strong> |
                                Registrado: {{ $usuario->created_at->format('d/m/Y H:i') }}
                                @if($usuario->updated_at != $usuario->created_at)
                                | Última modificación: {{ $usuario->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-user-edit fa-2x text-white"></i>
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

            <form action="{{ route('usuarios.update', $usuario) }}" method="POST" id="usuarioForm" novalidate>
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle text-primary mr-2"></i>
                                    Información Básica del Usuario
                                </h6>
                                <small class="text-muted">Modifica los datos principales del usuario</small>
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
                            <!-- Nombre del Usuario -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-user text-primary mr-1"></i>
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white border-primary">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                        name="name"
                                        id="name"
                                        class="form-control form-control-lg border-left-0 @error('name') is-invalid @enderror"
                                        placeholder="Ej: Juan Pérez"
                                        value="{{ old('name', $usuario->name) }}"
                                        maxlength="255"
                                        data-original="{{ $usuario->name }}"
                                        data-field="required"
                                        autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light border-left-0" id="nameCounter">
                                            <small class="text-muted">0/255</small>
                                        </span>
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb text-warning mr-1"></i>
                                    Ingrese el nombre completo del usuario
                                </small>
                            </div>

                            <!-- Email del Usuario -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-envelope text-success mr-1"></i>
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white border-success">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="email"
                                        name="email"
                                        id="email"
                                        class="form-control form-control-lg border-left-0 @error('email') is-invalid @enderror"
                                        placeholder="usuario@ejemplo.com"
                                        value="{{ old('email', $usuario->email) }}"
                                        maxlength="255"
                                        data-original="{{ $usuario->email }}"
                                        data-field="required">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="button" id="validateEmail"
                                            data-toggle="tooltip" title="Validar formato de email">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Email único para acceso al sistema
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contraseña -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-warning">
                                    <i class="fas fa-lock text-warning mr-2"></i>
                                    Cambiar Contraseña (Opcional)
                                </h6>
                                <small class="text-muted">Deje los campos vacíos si no desea cambiar la contraseña</small>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="changePassword">
                                    <label class="form-check-label small text-muted" for="changePassword">
                                        Cambiar contraseña
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="passwordSection" style="display: none;">
                        <div class="row">
                            <!-- Nueva Contraseña -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-lock text-info mr-1"></i>
                                    Nueva Contraseña
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white border-info">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password"
                                        name="password"
                                        id="password"
                                        class="form-control border-left-0 @error('password') is-invalid @enderror"
                                        placeholder="••••••••"
                                        minlength="8">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-info" type="button" id="togglePassword"
                                            data-toggle="tooltip" title="Mostrar/Ocultar contraseña">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar" id="passwordStrength" style="width: 0%"></div>
                                    </div>
                                    <small class="form-text" id="passwordStrengthText">
                                        Mínimo 8 caracteres (opcional)
                                    </small>
                                </div>
                            </div>

                            <!-- Confirmar Nueva Contraseña -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-shield-alt text-warning mr-1"></i>
                                    Confirmar Nueva Contraseña
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white border-warning">
                                            <i class="fas fa-shield-alt"></i>
                                        </span>
                                    </div>
                                    <input type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control border-left-0"
                                        placeholder="••••••••">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light border-left-0" id="passwordMatch">
                                            <i class="fas fa-check text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle text-info mr-1"></i>
                                    Repita la nueva contraseña para confirmar
                                </small>
                            </div>
                        </div>

                        <!-- Indicadores de Seguridad -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-left-info shadow-sm">
                                    <div class="card-body py-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    <i class="fas fa-shield-alt text-info mr-1"></i>
                                                    Seguridad de la Nueva Contraseña
                                                </div>
                                                <div class="text-sm" id="securityRequirements">
                                                    <div class="mb-1">
                                                        <i class="fas fa-check text-muted mr-1" id="lengthCheck"></i>
                                                        <span>Mínimo 8 caracteres</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fas fa-check text-muted mr-1" id="uppercaseCheck"></i>
                                                        <span>Al menos una mayúscula</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fas fa-check text-muted mr-1" id="lowercaseCheck"></i>
                                                        <span>Al menos una minúscula</span>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-check text-muted mr-1" id="numberCheck"></i>
                                                        <span>Al menos un número</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="bg-info rounded-circle p-3">
                                                    <i class="fas fa-user-shield fa-2x text-white"></i>
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
                                    <a href="{{ route('usuarios.index') }}"
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
                                        <span id="submitText">Actualizar Usuario</span>
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
        const form = document.getElementById('usuarioForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const cancelBtn = document.getElementById('cancelBtn');
        const resetBtn = document.getElementById('resetChanges');
        const compareBtn = document.getElementById('compareChanges');

        // Inputs
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const changePasswordCheckbox = document.getElementById('changePassword');
        const passwordSection = document.getElementById('passwordSection');

        // Display elements
        const nameCounter = document.getElementById('nameCounter');
        const changeProgress = document.getElementById('changeProgress');
        const changeText = document.getElementById('changeText');
        const validateEmailBtn = document.getElementById('validateEmail');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordStrengthText = document.getElementById('passwordStrengthText');
        const passwordMatchIcon = document.getElementById('passwordMatch');

        // Valores originales
        const originalValues = {
            name: nameInput.dataset.original,
            email: emailInput.dataset.original
        };

        let hasChanges = false;

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Función para validar email
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Función para calcular fortaleza de contraseña
        function calculatePasswordStrength(password) {
            let strength = 0;
            let checks = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password)
            };

            Object.values(checks).forEach(check => {
                if (check) strength += 25;
            });

            updateSecurityChecks(checks);
            return {
                strength,
                checks
            };
        }

        // Función para actualizar checks de seguridad
        function updateSecurityChecks(checks) {
            const checkElements = {
                length: document.getElementById('lengthCheck'),
                uppercase: document.getElementById('uppercaseCheck'),
                lowercase: document.getElementById('lowercaseCheck'),
                number: document.getElementById('numberCheck')
            };

            Object.keys(checks).forEach(key => {
                const element = checkElements[key];
                if (checks[key]) {
                    element.className = 'fas fa-check text-success mr-1';
                } else {
                    element.className = 'fas fa-times text-danger mr-1';
                }
            });
        }

        // Función para detectar cambios
        function detectChanges() {
            const currentValues = {
                name: nameInput.value.trim(),
                email: emailInput.value.trim()
            };

            let changedFields = 0;
            let totalFields = Object.keys(originalValues).length;

            Object.keys(originalValues).forEach(key => {
                if (currentValues[key] !== originalValues[key]) {
                    changedFields++;
                }
            });

            // Verificar si se está cambiando la contraseña
            const changingPassword = changePasswordCheckbox.checked && passwordInput.value.length > 0;

            hasChanges = changedFields > 0 || changingPassword;

            // Actualizar barra de progreso
            const percentage = hasChanges ? Math.min((changedFields / totalFields) * 100, 100) : 0;
            changeProgress.style.width = percentage + '%';
            changeProgress.setAttribute('aria-valuenow', percentage);

            if (hasChanges) {
                let changeDescription = '';
                if (changedFields > 0) {
                    changeDescription = `${changedFields} campo${changedFields > 1 ? 's' : ''} modificado${changedFields > 1 ? 's' : ''}`;
                }
                if (changingPassword) {
                    changeDescription += changedFields > 0 ? ' + contraseña' : 'Contraseña modificada';
                }
                changeText.textContent = changeDescription;
                changeProgress.classList.remove('bg-success');
                changeProgress.classList.add('bg-warning');
            } else {
                changeText.textContent = 'Sin cambios';
                changeProgress.classList.remove('bg-warning');
                changeProgress.classList.add('bg-success');
            }

            // Validar contraseñas si se está cambiando
            let passwordValid = true;
            if (changingPassword) {
                const {
                    passesServerValidation
                } = calculatePasswordStrength(passwordInput.value);
                passwordValid = passwordInput.value.length >= 8 &&
                    passwordInput.value === passwordConfirmationInput.value &&
                    passesServerValidation;
            }

            // Habilitar/deshabilitar botones
            submitBtn.disabled = !hasChanges || !passwordValid;
            resetBtn.disabled = !hasChanges;
            compareBtn.disabled = !hasChanges;
        }

        // Función para validar coincidencia de contraseñas
        function checkPasswordMatch() {
            if (!changePasswordCheckbox.checked) {
                passwordMatchIcon.innerHTML = '<i class="fas fa-check text-muted"></i>';
                return true;
            }

            const password = passwordInput.value;
            const confirmation = passwordConfirmationInput.value;

            if (confirmation === '') {
                passwordMatchIcon.innerHTML = '<i class="fas fa-minus text-muted"></i>';
                return password === '';
            }

            if (password === confirmation) {
                passwordMatchIcon.innerHTML = '<i class="fas fa-check text-success"></i>';
                return true;
            } else {
                passwordMatchIcon.innerHTML = '<i class="fas fa-times text-danger"></i>';
                return false;
            }
        }

        // Función para resetear cambios
        function resetChanges() {
            if (confirm('¿Estás seguro de que quieres restaurar los valores originales?')) {
                nameInput.value = originalValues.name;
                emailInput.value = originalValues.email;
                changePasswordCheckbox.checked = false;
                passwordSection.style.display = 'none';
                passwordInput.value = '';
                passwordConfirmationInput.value = '';

                updateNameCounter();
                detectChanges();
            }
        }

        // Función para mostrar comparación de cambios
        function showComparison() {
            let changes = [];

            if (nameInput.value.trim() !== originalValues.name) {
                changes.push(`• Nombre: "${originalValues.name}" → "${nameInput.value.trim()}"`);
            }
            if (emailInput.value.trim() !== originalValues.email) {
                changes.push(`• Email: "${originalValues.email}" → "${emailInput.value.trim()}"`);
            }
            if (changePasswordCheckbox.checked && passwordInput.value.length > 0) {
                changes.push(`• Contraseña: Se cambiará la contraseña`);
            }

            if (changes.length > 0) {
                alert('Cambios realizados:\n\n' + changes.join('\n'));
            }
        }

        // Función para actualizar contador de nombre
        function updateNameCounter() {
            const length = nameInput.value.length;
            nameCounter.innerHTML = `<small class="text-muted">${length}/255</small>`;
        }

        // Event listeners
        nameInput.addEventListener('input', function() {
            updateNameCounter();
            detectChanges();
        });

        emailInput.addEventListener('input', function() {
            detectChanges();
        });

        changePasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordSection.style.display = 'block';
            } else {
                passwordSection.style.display = 'none';
                passwordInput.value = '';
                passwordConfirmationInput.value = '';
                passwordStrength.style.width = '0%';
                passwordStrengthText.textContent = 'Mínimo 8 caracteres (opcional)';
                passwordStrengthText.className = 'form-text text-muted';
            }
            detectChanges();
        });

        passwordInput.addEventListener('input', function() {
            if (changePasswordCheckbox.checked) {
                const {
                    strength
                } = calculatePasswordStrength(this.value);

                passwordStrength.style.width = strength + '%';

                if (strength < 50) {
                    passwordStrength.className = 'progress-bar bg-danger';
                    passwordStrengthText.textContent = 'Contraseña débil';
                    passwordStrengthText.className = 'form-text text-danger';
                } else if (strength < 75) {
                    passwordStrength.className = 'progress-bar bg-warning';
                    passwordStrengthText.textContent = 'Contraseña media';
                    passwordStrengthText.className = 'form-text text-warning';
                } else {
                    passwordStrength.className = 'progress-bar bg-success';
                    passwordStrengthText.textContent = 'Contraseña fuerte';
                    passwordStrengthText.className = 'form-text text-success';
                }

                checkPasswordMatch();
            }
            detectChanges();
        });

        passwordConfirmationInput.addEventListener('input', function() {
            checkPasswordMatch();
            detectChanges();
        });

        validateEmailBtn.addEventListener('click', function() {
            const email = emailInput.value.trim();
            if (email) {
                if (validateEmail(email)) {
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success');
                } else {
                    emailInput.classList.remove('is-valid');
                    emailInput.classList.add('is-invalid');
                    this.innerHTML = '<i class="fas fa-times"></i>';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-danger');
                }
            }
        });

        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

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
        detectChanges();
        updateNameCounter();
    });
</script>
@endsection
