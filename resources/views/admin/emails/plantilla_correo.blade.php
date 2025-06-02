<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $asunto ?? 'Mensaje de TAG & SOLE' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }
        .header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            margin: 0 0 10px 0;
            letter-spacing: 2px;
        }
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }
        .admin-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            display: inline-block;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #28a745;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.8;
            color: #444;
            margin: 25px 0;
        }
        .message-content p {
            margin: 15px 0;
        }
        .signature-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-left: 4px solid #28a745;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .signature-title {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .signature-info {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer-brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #28a745;
        }
        .footer-info {
            font-size: 14px;
            opacity: 0.9;
            margin: 8px 0;
        }
        .footer-links {
            margin: 20px 0;
        }
        .footer-links a {
            color: #28a745;
            text-decoration: none;
            margin: 0 12px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .footer-links a:hover {
            color: #20c997;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #28a745, transparent);
            margin: 30px 0;
            border: none;
        }
        .highlight-box {
            background: linear-gradient(135deg, #e8f5e8, #d4edda);
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .timestamp {
            font-size: 12px;
            color: #999;
            text-align: right;
            margin: 15px 0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1 class="logo">🛍️ TAG & SOLE</h1>
                <p class="tagline">Sneakers & Moda Urbana</p>
                <div class="admin-badge">
                    👤 ADMINISTRACIÓN
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Estimado/a {{ $destinatario ?? 'Cliente' }},
            </div>

            <div class="message-content">
                {!! nl2br(e($contenido ?? 'Contenido del mensaje no disponible.')) !!}
            </div>

            <hr class="divider">

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-title">
                    📧 Mensaje enviado por:
                </div>
                <div class="signature-info">
                    <strong>{{ $remitente ?? 'Administrador TAG & SOLE' }}</strong><br>
                    <em>{{ $email_remitente ?? 'l21281040@toluca.tecnm.mx' }}</em><br>
                    Equipo de Administración TAG & SOLE<br>
                    <small>{{ $fecha ?? now()->format('d/m/Y H:i:s') }}</small>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="highlight-box">
                <h4 style="color: #28a745; margin-bottom: 15px;">📞 Información de Contacto</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                    <div>
                        <strong>🏪 Tienda Física:</strong><br>
                        Centro Comercial Galerías Toluca<br>
                        Toluca, Estado de México
                    </div>
                    <div>
                        <strong>📱 Contacto:</strong><br>
                        Tel: +52 722 123 4567<br>
                        Email: info@tagsole.com
                    </div>
                </div>
            </div>

            <div class="timestamp">
                ⏰ Enviado el {{ $fecha ?? now()->format('d/m/Y \a \l\a\s H:i:s') }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">TAG & SOLE</div>
            <div class="footer-info">La mejor tienda de sneakers y moda urbana en Toluca</div>
            <div class="footer-info">Centro Comercial Galerías Toluca, Toluca, Estado de México</div>

            <div class="footer-links">
                <a href="#">🏠 Inicio</a>
                <a href="#">🛍️ Tienda</a>
                <a href="#">📞 Contacto</a>
                <a href="#">ℹ️ Acerca de</a>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #495057;">
                <div style="font-size: 12px; opacity: 0.8;">
                    📧 Este correo fue enviado desde el panel de administración de TAG & SOLE<br>
                    Si recibiste este correo por error, por favor contáctanos inmediatamente
                </div>

                <div style="margin-top: 15px; font-size: 11px; opacity: 0.6;">
                    © {{ date('Y') }} TAG & SOLE. Todos los derechos reservados.<br>
                    Sistema de gestión de correos electrónicos v1.0
                </div>
            </div>
        </div>
    </div>
</body>
</html>
