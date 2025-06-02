<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Correo Electrónico - TAG & SOLE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 2rem 0;
        }
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
            border-left: 5px solid #28a745;
        }
        .email-preview {
            background: white;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1rem 0;
        }
        .quick-templates {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .template-btn {
            margin: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-envelope"></i> Enviar Correo Electrónico</h1>
                    <p class="mb-0">Panel de administración TAG & SOLE - Sistema de comunicación</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Formulario Principal -->
            <div class="col-md-8">
                <div class="form-section">
                    <h3 class="mb-4"><i class="fas fa-paper-plane text-success"></i> Nuevo Correo</h3>

                    <form method="POST" action="{{ route('admin.emails.send') }}" id="emailForm">
                        @csrf

                        <!-- Destinatario -->
                        <div class="mb-3">
                            <label for="destinatario" class="form-label">
                                <i class="fas fa-user"></i> Para: <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <select class="form-select" id="userSelect" onchange="fillEmailFromUser()">
                                    <option value="">Seleccionar usuario...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->email }}" data-name="{{ $user->firstName }} {{ $user->lastName }}">
                                            {{ $user->firstName }} {{ $user->lastName }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="email"
                                   class="form-control mt-2 @error('destinatario') is-invalid @enderror"
                                   id="destinatario"
                                   name="destinatario"
                                   placeholder="o escribir email manualmente..."
                                   value="{{ old('destinatario') }}"
                                   required>
                            @error('destinatario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Asunto -->
                        <div class="mb-3">
                            <label for="asunto" class="form-label">
                                <i class="fas fa-tag"></i> Asunto: <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('asunto') is-invalid @enderror"
                                   id="asunto"
                                   name="asunto"
                                   placeholder="Asunto del correo..."
                                   value="{{ old('asunto') }}"
                                   required>
                            @error('asunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Plantillas Rápidas -->
                        <div class="quick-templates">
                            <h6><i class="fas fa-templates"></i> Plantillas Rápidas:</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary template-btn" onclick="loadTemplate('welcome')">
                                Bienvenida
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info template-btn" onclick="loadTemplate('order')">
                                Pedido
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning template-btn" onclick="loadTemplate('promo')">
                                Promoción
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success template-btn" onclick="loadTemplate('support')">
                                Soporte
                            </button>
                        </div>

                        <!-- Contenido -->
                        <div class="mb-4">
                            <label for="contenido_mail" class="form-label">
                                <i class="fas fa-edit"></i> Contenido del mensaje: <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('contenido_mail') is-invalid @enderror"
                                      id="contenido_mail"
                                      name="contenido_mail"
                                      rows="8"
                                      placeholder="Escribe aquí el contenido de tu mensaje..."
                                      required>{{ old('contenido_mail') }}</textarea>
                            @error('contenido_mail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>

                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-outline-secondary" onclick="previewEmail()">
                                <i class="fas fa-eye"></i> Vista Previa
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Enviar Correo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="col-md-4">
                <!-- Estadísticas -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fas fa-chart-line"></i> Estadísticas de Email</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="text-success">{{ $users->count() }}</h4>
                            <p class="text-muted">Usuarios registrados</p>
                        </div>
                        <hr>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i>
                            Última actualización: {{ now()->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5><i class="fas fa-bolt"></i> Acciones Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="sendTestEmail()">
                                <i class="fas fa-flask"></i> Enviar Email de Prueba
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-shopping-bag"></i> Ver Pedidos Recientes
                            </a>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-users"></i> Gestionar Usuarios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista Previa Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-eye"></i> Vista Previa del Correo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="emailPreviewContent" class="email-preview">
                            <!-- El contenido se genera dinámicamente -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="$('#emailForm').submit()">
                            <i class="fas fa-paper-plane"></i> Enviar Ahora
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Llenar email desde selector de usuario
        function fillEmailFromUser() {
            const select = document.getElementById('userSelect');
            const emailInput = document.getElementById('destinatario');
            const asuntoInput = document.getElementById('asunto');

            if (select.value) {
                emailInput.value = select.value;
                const userName = select.options[select.selectedIndex].getAttribute('data-name');
                if (!asuntoInput.value) {
                    asuntoInput.value = `Mensaje desde TAG & SOLE para ${userName}`;
                }
            }
        }

        // Cargar plantillas predefinidas
        function loadTemplate(type) {
            const contenido = document.getElementById('contenido_mail');
            const asunto = document.getElementById('asunto');

            const templates = {
                welcome: {
                    asunto: '¡Bienvenido a TAG & SOLE!',
                    contenido: `¡Hola!

¡Bienvenido a la familia TAG & SOLE! 🛍️

Estamos emocionados de tenerte como parte de nuestra comunidad de sneakerheads y amantes de la moda urbana.

En TAG & SOLE encontrarás:
✅ Las últimas tendencias en sneakers
✅ Ropa urbana de calidad
✅ Accesorios únicos
✅ Atención personalizada

¡Explora nuestro catálogo y encuentra tu estilo!

Saludos,
El equipo de TAG & SOLE`
                },
                order: {
                    asunto: 'Actualización de tu pedido - TAG & SOLE',
                    contenido: `Hola,

Te escribimos para informarte sobre el estado de tu pedido.

Tu pedido está siendo procesado y pronto recibirás más información sobre el envío.

Si tienes alguna pregunta, no dudes en contactarnos.

¡Gracias por elegir TAG & SOLE!

Saludos,
El equipo de TAG & SOLE`
                },
                promo: {
                    asunto: '🔥 ¡Oferta especial solo para ti! - TAG & SOLE',
                    contenido: `¡Hola!

¡Tenemos una oferta especial solo para ti! 🔥

🎯 Descuentos especiales en sneakers seleccionados
🎯 Envío gratis en compras mayores a $1,500
🎯 Nuevas colecciones disponibles

No te pierdas esta oportunidad única.

¡Visítanos o explora nuestra tienda en línea!

Saludos,
El equipo de TAG & SOLE`
                },
                support: {
                    asunto: 'Respuesta de Soporte - TAG & SOLE',
                    contenido: `Hola,

Gracias por contactarte con nosotros.

Hemos revisado tu consulta y queremos ayudarte de la mejor manera posible.

[Personaliza este mensaje según la consulta específica]

Si necesitas más información, no dudes en responder este correo.

Estamos aquí para ayudarte.

Saludos,
Equipo de Soporte TAG & SOLE`
                }
            };

            if (templates[type]) {
                if (!asunto.value) {
                    asunto.value = templates[type].asunto;
                }
                contenido.value = templates[type].contenido;
            }
        }

        // Vista previa del email
        function previewEmail() {
            const destinatario = document.getElementById('destinatario').value;
            const asunto = document.getElementById('asunto').value;
            const contenido = document.getElementById('contenido_mail').value;

            if (!destinatario || !asunto || !contenido) {
                alert('Por favor completa todos los campos antes de ver la vista previa.');
                return;
            }

            const previewContent = `
                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; background: white;">
                    <div style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; margin: -20px -20px 20px -20px;">
                        <h3 style="margin: 0;">🛍️ TAG & SOLE</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Administración</p>
                    </div>
                    <div style="margin: 20px 0;">
                        <p><strong>Para:</strong> ${destinatario}</p>
                        <p><strong>Asunto:</strong> ${asunto}</p>
                        <p><strong>Fecha:</strong> ${new Date().toLocaleDateString('es-ES')}</p>
                    </div>
                    <hr>
                    <div style="line-height: 1.6; color: #333;">
                        ${contenido.replace(/\n/g, '<br>')}
                    </div>
                    <hr>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px; text-align: center; font-size: 14px; color: #666;">
                        <p style="margin: 0;"><strong>TAG & SOLE</strong> - Tienda de Sneakers y Moda Urbana</p>
                        <p style="margin: 5px 0 0 0;">Centro Comercial Galerías Toluca | +52 722 123 4567</p>
                    </div>
                </div>
            `;

            document.getElementById('emailPreviewContent').innerHTML = previewContent;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }

        // Enviar email de prueba
        function sendTestEmail() {
            if (confirm('¿Enviar un email de prueba a admin@test.com?')) {
                // Aquí podrías hacer una llamada AJAX para enviar el email de prueba
                alert('Función de email de prueba - implementar según necesidades');
            }
        }
    </script>
</body>
</html>
