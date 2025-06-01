@extends('template.master')

@section('contenido_central')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="bg-white shadow-lg rounded-lg p-5">
                <!-- Logo y título -->
                <div class="text-center mb-4">
                    <h1 class="h3 text-success font-weight-bold">TAG & SOLE</h1>
                    <p class="text-muted">Únete a la familia TAG & SOLE</p>
                </div>

                <!-- Formulario de registro -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">
                                <i class="fas fa-user me-2"></i>Nombre <span class="text-danger">*</span>
                            </label>
                            <input id="firstName"
                                   type="text"
                                   name="firstName"
                                   class="form-control @error('firstName') is-invalid @enderror"
                                   value="{{ old('firstName') }}"
                                   required
                                   autofocus
                                   autocomplete="given-name"
                                   placeholder="Tu nombre">
                            @error('firstName')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="lastName" class="form-label">
                                <i class="fas fa-user me-2"></i>Apellido <span class="text-danger">*</span>
                            </label>
                            <input id="lastName"
                                   type="text"
                                   name="lastName"
                                   class="form-control @error('lastName') is-invalid @enderror"
                                   value="{{ old('lastName') }}"
                                   required
                                   autocomplete="family-name"
                                   placeholder="Tu apellido">
                            @error('lastName')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span>
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               placeholder="tu@email.com">
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">
                            <i class="fas fa-phone me-2"></i>Teléfono
                        </label>
                        <input id="phoneNumber"
                               type="tel"
                               name="phoneNumber"
                               class="form-control @error('phoneNumber') is-invalid @enderror"
                               value="{{ old('phoneNumber') }}"
                               autocomplete="tel"
                               placeholder="+52 722 123 4567">
                        @error('phoneNumber')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Municipio -->
                    <div class="mb-3">
                        <label for="MunicipalityId" class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Municipio
                        </label>
                        <select id="MunicipalityId"
                                name="MunicipalityId"
                                class="form-select @error('MunicipalityId') is-invalid @enderror">
                            <option value="">Selecciona tu municipio</option>
                            @if(isset($municipalities))
                                @foreach($municipalities as $id => $name)
                                    <option value="{{ $id }}" {{ old('MunicipalityId') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('MunicipalityId')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input id="password"
                                       type="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Mínimo 8 caracteres">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmar contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input id="password_confirmation"
                                       type="password"
                                       name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Confirma tu contraseña">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Términos y condiciones -->
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input @error('terms') is-invalid @enderror"
                               id="terms"
                               name="terms"
                               required>
                        <label class="form-check-label" for="terms">
                            Acepto los <a href="#" class="text-success">términos y condiciones</a>
                            y la <a href="#" class="text-success">política de privacidad</a>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Newsletter -->
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="newsletter"
                               name="newsletter"
                               checked>
                        <label class="form-check-label" for="newsletter">
                            Quiero recibir ofertas exclusivas y novedades por email
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Crear Mi Cuenta
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <hr class="my-4">

                <!-- Login -->
                <div class="text-center">
                    <p class="text-muted mb-2">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-success">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </a>
                </div>

                <!-- Beneficios -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="text-center mb-3">Al crear tu cuenta obtienes:</h6>
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-2">
                            <i class="fas fa-percent text-success mb-1 d-block"></i>
                            <small class="text-muted">Descuentos exclusivos</small>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <i class="fas fa-heart text-success mb-1 d-block"></i>
                            <small class="text-muted">Lista de favoritos</small>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <i class="fas fa-truck text-success mb-1 d-block"></i>
                            <small class="text-muted">Seguimiento de envíos</small>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <i class="fas fa-star text-success mb-1 d-block"></i>
                            <small class="text-muted">Puntos de recompensa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const toggleButtons = [
        { button: 'togglePassword', input: 'password', icon: 'togglePasswordIcon' },
        { button: 'togglePasswordConfirm', input: 'password_confirmation', icon: 'togglePasswordConfirmIcon' }
    ];

    toggleButtons.forEach(item => {
        const toggleButton = document.getElementById(item.button);
        const passwordInput = document.getElementById(item.input);
        const toggleIcon = document.getElementById(item.icon);

        if (toggleButton && passwordInput && toggleIcon) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                if (type === 'password') {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        }
    });

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            // You can add visual feedback here
        });
    }

    // Password confirmation match
    const passwordConfirm = document.getElementById('password_confirmation');
    if (passwordConfirm && passwordInput) {
        passwordConfirm.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        return strength;
    }

    // Auto-focus en el primer campo con error
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        firstError.focus();
    }

    // Animación de entrada
    const registerCard = document.querySelector('.shadow-lg');
    if (registerCard) {
        registerCard.style.opacity = '0';
        registerCard.style.transform = 'translateY(20px)';

        setTimeout(() => {
            registerCard.style.transition = 'all 0.3s ease';
            registerCard.style.opacity = '1';
            registerCard.style.transform = 'translateY(0)';
        }, 100);
    }
});
</script>
@endsection

@section('styles')
<style>
.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.text-success {
    color: #28a745 !important;
}

.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.invalid-feedback {
    display: block;
}

/* Animaciones suaves */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Required field indicator */
.text-danger {
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .shadow-lg {
        margin: 0 10px;
    }

    .row .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
