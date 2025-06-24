@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle text-primary mr-2"></i>
                Nuevo Usuario
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
                    <li class="breadcrumb-item active text-gray-600">Nuevo</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('usuarios.index') }}" class="btn btn-light btn-sm border shadow-sm">
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

            <form action="{{ route('usuarios.store') }}" method="POST" id="usuarioForm" novalidate>
                @csrf

                <!-- Información Básica -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle text-primary mr-2"></i>
                                    Información Básica del Usuario
                                </h6>
                                <small class="text-muted">Complete los datos principales del usuario</small>
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
                                        value="{{ old('name') }}"
                                        maxlength="255"
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
                                        value="{{ old('email') }}"
                                        maxlength="255"
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
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-lock text-warning mr-2"></i>
                            Configuración de Contraseña
                        </h6>
                        <small class="text-muted">Configure la contraseña de acceso del usuario</small>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Contraseña -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-lock text-info mr-1"></i>
                                    Contraseña <span class="text-danger">*</span>
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
                                        minlength="8"
                                        data-field="required">
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
                                        Mínimo 8 caracteres
                                    </small>
                                </div>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="col-lg-6 mb-4">
                                <label class="form-label text-gray-700 font-weight-bold">
                                    <i class="fas fa-shield-alt text-warning mr-1"></i>
                                    Confirmar Contraseña <span class="text-danger">*</span>
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
                                        placeholder="••••••••"
                                        data-field="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light border-left-0" id="passwordMatch">
                                            <i class="fas fa-times text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle text-info mr-1"></i>
                                    Repita la contraseña para confirmar
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
                                                    Seguridad de la Contraseña
                                                </div>
                                                <div class="text-sm" id="securityRequirements">
                                                    <div class="mb-1">
                                                        <i class="fas fa-times text-danger mr-1" id="lengthCheck"></i>
                                                        <span>Mínimo 8 caracteres</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fas fa-times text-danger mr-1" id="uppercaseCheck"></i>
                                                        <span>Al menos una mayúscula</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fas fa-times text-danger mr-1" id="lowercaseCheck"></i>
                                                        <span>Al menos una minúscula</span>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-times text-danger mr-1" id="numberCheck"></i>
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
                                    <a href="{{ route('usuarios.index') }}"
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
                                        <span id="submitText">Guardar Usuario</span>
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

        // Inputs
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');

        // Display elements
        const nameCounter = document.getElementById('nameCounter');
        const progressBar = document.getElementById('formProgress');
        const progressText = document.getElementById('progressText');
        const validateEmailBtn = document.getElementById('validateEmail');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordStrengthText = document.getElementById('passwordStrengthText');
        const passwordMatchIcon = document.getElementById('passwordMatch');

        let formChanged = false;
        const requiredFields = document.querySelectorAll('[data-field="required"]');

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

            // Validar que cumpla con el regex completo del servidor
            const serverRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
            const passesServerValidation = serverRegex.test(password);

            Object.values(checks).forEach(check => {
                if (check) strength += 25;
            });

            // Solo mostrar como "fuerte" si pasa la validación del servidor
            if (strength === 100 && !passesServerValidation) {
                strength = 75; // Reducir si no pasa la validación completa
            }

            // Actualizar indicadores visuales
            updateSecurityChecks(checks);

            return {
                strength,
                checks,
                passesServerValidation
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

        // Función para actualizar el progreso del formulario
        function updateProgress() {
            let completedFields = 0;
            const requiredFieldsCount = 4; // name, email, password, password_confirmation

            requiredFields.forEach(field => {
                if (field.value.trim() !== '') {
                    completedFields++;
                }
            });

            const percentage = (completedFields / requiredFieldsCount) * 100;
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
            progressText.textContent = `${completedFields}/${requiredFieldsCount} campos completados`;

            // Validar que las contraseñas coincidan Y cumplan con los requisitos del servidor
            const {
                passesServerValidation
            } = calculatePasswordStrength(passwordInput.value);
            const passwordsMatch = passwordInput.value === passwordConfirmationInput.value &&
                passwordInput.value.length >= 8 &&
                passesServerValidation;

            submitBtn.disabled = completedFields < requiredFieldsCount || !passwordsMatch;

            if (completedFields === requiredFieldsCount && passwordsMatch) {
                progressBar.classList.remove('bg-primary');
                progressBar.classList.add('bg-success');
            } else {
                progressBar.classList.remove('bg-success');
                progressBar.classList.add('bg-primary');
            }
        }

        // Función para validar coincidencia de contraseñas
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmation = passwordConfirmationInput.value;

            if (confirmation === '') {
                passwordMatchIcon.innerHTML = '<i class="fas fa-times text-danger"></i>';
                return false;
            }

            if (password === confirmation) {
                passwordMatchIcon.innerHTML = '<i class="fas fa-check text-success"></i>';
                return true;
            } else {
                passwordMatchIcon.innerHTML = '<i class="fas fa-times text-danger"></i>';
                return false;
            }
        }

        // Event listeners
        nameInput.addEventListener('input', function() {
            const length = this.value.length;
            nameCounter.innerHTML = `<small class="text-muted">${length}/255</small>`;
            formChanged = true;
            updateProgress();
        });

        emailInput.addEventListener('input', function() {
            formChanged = true;
            updateProgress();
        });

        passwordInput.addEventListener('input', function() {
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
            formChanged = true;
            updateProgress();
        });

        passwordConfirmationInput.addEventListener('input', function() {
            checkPasswordMatch();
            formChanged = true;
            updateProgress();
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
                const inputs = Array.from(form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]'));
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

        // Inicializar progreso
        updateProgress();
    });
</script>

@endsection
