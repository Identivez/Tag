<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Envío - TAG & SOLE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .result-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        .result-card {
            max-width: 500px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .error-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .result-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .result-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .result-message {
            opacity: 0.9;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="result-container">
        <div class="result-card">
            @if($var === '1')
                <!-- Éxito -->
                <div class="success-header">
                    <div class="result-icon pulse">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="result-title">¡Correo Enviado!</h2>
                    <p class="result-message">El mensaje se ha enviado correctamente</p>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>
                            <strong>Éxito:</strong> {!! $msj !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-success">📊 Detalles del envío:</h6>
                        <ul class="list-unstyled ms-3">
                            <li><i class="fas fa-clock text-muted me-2"></i> Enviado: {{ now()->format('d/m/Y H:i:s') }}</li>
                            <li><i class="fas fa-server text-muted me-2"></i> Sistema: TAG & SOLE Admin</li>
                            <li><i class="fas fa-user text-muted me-2"></i> Remitente: {{ auth()->user()->firstName ?? 'Admin' }}</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route($ruta_boton) }}" class="btn btn-success btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>{{ $mensaje_boton }}
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Volver al Dashboard
                        </a>
                    </div>
                </div>

            @else
                <!-- Error -->
                <div class="error-header">
                    <div class="result-icon pulse">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h2 class="result-title">Error en el Envío</h2>
                    <p class="result-message">No se pudo enviar el correo</p>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-3"></i>
                        <div>
                            <strong>Error:</strong> {!! $msj !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-danger">🔧 Posibles soluciones:</h6>
                        <ul class="list-unstyled ms-3">
                            <li><i class="fas fa-check text-muted me-2"></i> Verificar la configuración SMTP</li>
                            <li><i class="fas fa-check text-muted me-2"></i> Revisar la dirección de correo</li>
                            <li><i class="fas fa-check text-muted me-2"></i> Comprobar la conexión a internet</li>
                            <li><i class="fas fa-check text-muted me-2"></i> Contactar al administrador del sistema</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route($ruta_boton) }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-redo me-2"></i>{{ $mensaje_boton }}
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Volver al Dashboard
                        </a>
                    </div>
                </div>
            @endif

            <!-- Footer Information -->
            <div class="card-footer bg-light text-center">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>
                    Sistema de correos TAG & SOLE Admin Panel
                </small>
            </div>
        </div>
    </div>

    <!-- Auto-redirect después de 5 segundos en caso de éxito -->
    @if($var === '1')
        <script>
            setTimeout(function() {
                if (confirm('¿Deseas enviar otro correo? (Se redirigirá automáticamente en 5 segundos)')) {
                    window.location.href = '{{ route($ruta_boton) }}';
                }
            }, 5000);
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
