<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a TAG & SOLE!</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 36px;
            font-weight: bold;
        }
        .header p {
            margin: 0;
            font-size: 18px;
            opacity: 0.9;
        }
        .welcome-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 24px;
            color: #28a745;
            margin-bottom: 25px;
            font-weight: 700;
            text-align: center;
        }
        .welcome-message {
            font-size: 16px;
            line-height: 1.8;
            color: #444;
            margin: 25px 0;
            text-align: center;
        }
        .features-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }
        .features-title {
            color: #28a745;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .feature-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            font-size: 24px;
            margin-right: 15px;
            width: 40px;
            text-align: center;
        }
        .feature-text {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        .cta-section {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: white;
            color: #28a745;
            padding: 15px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
            transition: transform 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            color: #28a745;
        }
        .user-info {
            background-color: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            color: #28a745;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🛍️ TAG & SOLE</h1>
            <p>Sneakers & Moda Urbana</p>
            <div class="welcome-badge">
                ¡BIENVENIDO A LA FAMILIA!
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                ¡Hola {{ $usuario }}! 👋
            </div>

            <div class="welcome-message">
                <p><strong>¡Bienvenido a TAG & SOLE!</strong> 🎉</p>
                <p>Estamos emocionados de tenerte como parte de nuestra comunidad de sneakerheads y amantes de la moda urbana.</p>
                <p>Tu cuenta ha sido creada exitosamente y ya puedes disfrutar de todos nuestros beneficios.</p>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <h4 style="color: #28a745; margin-bottom: 15px;">📋 Información de tu cuenta:</h4>
                <p><strong>📧 Email:</strong> {{ $email }}</p>
                <p><strong>📅 Fecha de registro:</strong> {{ $fecha_registro }}</p>
                <p><strong>🎯 Estado:</strong> Cuenta activa</p>
            </div>

            <!-- Features Section -->
            <div class="features-section">
                <div class="features-title">
                    🌟 ¿Qué puedes hacer en TAG & SOLE?
                </div>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">👟</div>
                        <div class="feature-text">Explorar las últimas tendencias en sneakers</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">👕</div>
                        <div class="feature-text">Descubrir ropa urbana de calidad</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">❤️</div>
                        <div class="feature-text">Guardar productos en favoritos</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛒</div>
                        <div class="feature-text">Realizar compras seguras online</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📦</div>
                        <div class="feature-text">Rastrear tus pedidos en tiempo real</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">⭐</div>
                        <div class="feature-text">Escribir reseñas de productos</div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-section">
                <h3 style="margin: 0 0 15px 0;">🚀 ¡Comienza tu experiencia TAG & SOLE!</h3>
                <p style="margin: 0 0 20px 0; opacity: 0.9;">
                    Explora nuestra colección y encuentra tu estilo único
                </p>
                <a href="#" class="cta-button">
                    🛍️ EXPLORAR TIENDA
                </a>
            </div>

            <!-- Tips Section -->
            <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h4 style="color: #856404; margin-bottom: 15px;">💡 Consejos para aprovechar al máximo tu cuenta:</h4>
                <ul style="margin: 10px 0; padding-left: 20px; color: #856404;">
                    <li>Completa tu perfil para recibir recomendaciones personalizadas</li>
                    <li>Suscríbete a nuestro newsletter para ofertas exclusivas</li>
                    <li>Síguenos en redes sociales para las últimas novedades</li>
                    <li>Revisa nuestra sección de ofertas especiales regularmente</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3 style="margin: 0 0 15px 0; color: #28a745;">TAG & SOLE</h3>
            <p style="margin: 10px 0;">La mejor tienda de sneakers y moda urbana en Toluca</p>
            <p style="margin: 5px 0; font-size: 14px;">📍 Centro Comercial Galerías Toluca</p>
            <p style="margin: 5px 0; font-size: 14px;">📞 +52 722 123 4567 | 📧 info@tagsole.com</p>

            <div class="social-links">
                <a href="#">📘 Facebook</a>
                <a href="#">📷 Instagram</a>
                <a href="#">🐦 Twitter</a>
                <a href="#">📺 YouTube</a>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #495057; font-size: 12px; opacity: 0.8;">
                Este correo de bienvenida fue enviado el {{ $fecha }}<br>
                Si no creaste esta cuenta, por favor contáctanos inmediatamente.
            </div>
        </div>
    </div>
</body>
</html>
