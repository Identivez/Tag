@extends('template.master')

@section('contenido_central')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white shadow-lg rounded-lg p-5">
                <!-- Logo y título -->
                <div class="text-center mb-4">
                    <h1 class="h3 text-success font-weight-bold">TAG & SOLE</h1>
                    <p class="text-muted">Inicia sesión en tu cuenta</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Formulario de login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="tu@email.com">
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                        <div class="input-group">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Tu contraseña">
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

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="remember_me"
                               name="remember">
                        <label class="form-check-label" for="remember_me">
                            Recordarme
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>

                    <!-- Links adicionales -->
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-decoration-none text-muted me-3">
                                <i class="fas fa-key me-1"></i>¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Divider -->
                <hr class="my-4">

                <!-- Registro -->
                <div class="text-center">
                    <p class="text-muted mb-2">¿No tienes una cuenta?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                    </a>
                </div>

                <!-- Información adicional -->
                <div class="mt-4 p-3 bg-light rounded">
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="fas fa-shipping-fast text-success mb-2 d-block"></i>
                            <small class="text-muted">Envío gratis</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-undo text-success mb-2 d-block"></i>
                            <small class="text-muted">30 días de devolución</small>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-shield-alt text-success mb-2 d-block"></i>
                            <small class="text-muted">Compra segura</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enlaces de redes sociales -->
            <div class="text-center mt-4">
                <p class="text-muted mb-2">Síguenos en:</p>
                <a href="https://facebook.com/tagsole" class="text-decoration-none me-3" target="_blank">
                    <i class="fab fa-facebook-f fa-lg text-primary"></i>
                </a>
                <a href="https://instagram.com/tagsole" class="text-decoration-none me-3" target="_blank">
                    <i class="fab fa-instagram fa-lg text-danger"></i>
                </a>
                <a href="https://twitter.com/tagsole" class="text-decoration-none me-3" target="_blank">
                    <i class="fab fa-twitter fa-lg text-info"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
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

    // Auto-focus en el primer campo con error
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        firstError.focus();
    }

    // Animación de entrada
    const loginCard = document.querySelector('.shadow-lg');
    if (loginCard) {
        loginCard.style.opacity = '0';
        loginCard.style.transform = 'translateY(20px)';

        setTimeout(() => {
            loginCard.style.transition = 'all 0.3s ease';
            loginCard.style.opacity = '1';
            loginCard.style.transform = 'translateY(0)';
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

.form-control:focus {
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

/* Responsive adjustments */
@media (max-width: 576px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .shadow-lg {
        margin: 0 10px;
    }
}
</style>
@endsection
