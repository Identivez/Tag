<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Correos - TAG & SOLE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <div class="bg-info text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-history"></i> Historial de Correos</h1>
                    <p class="mb-0">Estadísticas y registros del sistema de comunicación</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.emails.form') }}" class="btn btn-light me-2">
                        <i class="fas fa-paper-plane"></i> Enviar Correo
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <i class="fas fa-paper-plane fa-2x text-success mb-2"></i>
                        <h4>{{ $stats['total_sent'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Correos Enviados</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-danger">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                        <h4>{{ $stats['total_failed'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Envíos Fallidos</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-info">
                    <div class="card-body">
                        <i class="fas fa-percentage fa-2x text-info mb-2"></i>
                        <h4>
                            @php
                                $total = ($stats['total_sent'] ?? 0) + ($stats['total_failed'] ?? 0);
                                $successRate = $total > 0 ? round((($stats['total_sent'] ?? 0) / $total) * 100, 1) : 0;
                            @endphp
                            {{ $successRate }}%
                        </h4>
                        <p class="text-muted mb-0">Tasa de Éxito</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h6 style="font-size: 1rem;">{{ $stats['last_sent'] ?? 'N/A' }}</h6>
                        <p class="text-muted mb-0">Último Envío</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-bolt"></i> Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.emails.form') }}" class="btn btn-success w-100">
                            <i class="fas fa-envelope me-2"></i>Nuevo Correo
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.emails.test') }}" class="btn btn-warning w-100">
                            <i class="fas fa-flask me-2"></i>Probar Sistema
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-info w-100" onclick="refreshStats()">
                            <i class="fas fa-sync me-2"></i>Actualizar Stats
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-secondary w-100" onclick="exportHistory()">
                            <i class="fas fa-download me-2"></i>Exportar Historial
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Envíos -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Historial de Envíos Recientes</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Próximamente:</strong> Esta sección mostrará el historial completo de correos enviados,
                    incluyendo destinatarios, asuntos, fechas y estado de entrega.
                </div>

                <!-- Tabla placeholder para historial -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Destinatario</th>
                                <th>Asunto</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos de ejemplo -->
                            <tr>
                                <td>{{ now()->format('d/m/Y H:i') }}</td>
                                <td>usuario@example.com</td>
                                <td>Bienvenido a TAG & SOLE</td>
                                <td><span class="badge bg-primary">Bienvenida</span></td>
                                <td><span class="badge bg-success">Enviado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ now()->subHours(2)->format('d/m/Y H:i') }}</td>
                                <td>cliente@test.com</td>
                                <td>Confirmación de Pedido #1001</td>
                                <td><span class="badge bg-info">Pedido</span></td>
                                <td><span class="badge bg-success">Enviado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDays(1)->format('d/m/Y H:i') }}</td>
                                <td>admin@test.com</td>
                                <td>Correo de Prueba</td>
                                <td><span class="badge bg-warning">Prueba</span></td>
                                <td><span class="badge bg-success">Enviado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación placeholder -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Configuración del Sistema -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h5><i class="fas fa-cogs"></i> Configuración del Sistema de Correos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Estado del Sistema</h6>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Sistema de correos operativo
                        </div>

                        <h6>Configuración SMTP</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Servidor SMTP:</span>
                                <span class="text-muted">{{ config('mail.host', 'No configurado') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Puerto:</span>
                                <span class="text-muted">{{ config('mail.port', 'No configurado') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Encriptación:</span>
                                <span class="text-muted">{{ config('mail.encryption', 'No configurado') }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h6>Plantillas Disponibles</h6>
                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                Contacto
                                <span class="badge bg-primary">Activa</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                Confirmación de Pedido
                                <span class="badge bg-primary">Activa</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                Bienvenida
                                <span class="badge bg-primary">Activa</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                Plantilla Admin
                                <span class="badge bg-primary">Activa</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar Plantillas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Actualizar estadísticas
        function refreshStats() {
            // Simular actualización de estadísticas
            alert('Función de actualización de estadísticas - Implementar según necesidades');
            // Aquí se implementaría una llamada AJAX para obtener stats actualizadas
        }

        // Exportar historial
        function exportHistory() {
            // Simular exportación
            alert('Función de exportación de historial - Implementar según necesidades');
            // Aquí se implementaría la exportación a CSV/Excel
        }

        // Auto-refresh cada 30 segundos (opcional)
        setInterval(function() {
            // Auto-actualizar estadísticas en producción
            console.log('Auto-refresh de estadísticas cada 30 segundos');
        }, 30000);
    </script>
</body>
</html>
