<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 0 0 5px 5px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .field-value {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo mensaje de contacto</h1>
        </div>

        <div class="content">
            <p>Has recibido un nuevo mensaje a través del formulario de contacto:</p>

            <div class="field">
                <div class="field-label">Nombre:</div>
                <div class="field-value">{{ $formData['name'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value">{{ $formData['email'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Asunto:</div>
                <div class="field-value">{{ $formData['subject'] }}</div>
            </div>

            <div class="field">
                <div class="field-label">Mensaje:</div>
                <div class="field-value">{{ $formData['message'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de Sneakers Market.</p>
            <p>&copy; {{ date('Y') }} Sneakers Market. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
