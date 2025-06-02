<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes PDF - TAG & SOLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .report-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .report-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .btn-group-custom {
            margin-top: 1rem;
        }
        .btn-group-custom .btn {
            margin: 0 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-file-pdf me-2"></i>Reportes PDF</h1>
                    <p class="mb-0">Genera reportes del sistema TAG & SOLE</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/dashboard" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Reporte de Productos -->
        <div class="report-card">
            <i class="fas fa-box report-icon text-success"></i>
            <h4>Reporte de Productos</h4>
            <p class="text-muted">Listado completo de productos con precios y stock</p>
            <div class="btn-group-custom">
                <a href="{{ route('pdf.productos', 1) }}" target="_blank" class="btn btn-success">
                    <i class="fas fa-eye me-1"></i>Ver PDF
                </a>
                <a href="{{ route('pdf.productos', 2) }}" class="btn btn-outline-success">
                    <i class="fas fa-download me-1"></i>Descargar
                </a>
            </div>
        </div>

        <!-- Reporte de Stock Bajo -->
        <div class="report-card">
            <i class="fas fa-exclamation-triangle report-icon text-danger"></i>
            <h4>Stock Bajo</h4>
            <p class="text-muted">Productos que necesitan reabastecimiento</p>
            <div class="btn-group-custom">
                <a href="{{ route('pdf.stock_bajo', 1) }}" target="_blank" class="btn btn-danger">
                    <i class="fas fa-eye me-1"></i>Ver PDF
                </a>
                <a href="{{ route('pdf.stock_bajo', 2) }}" class="btn btn-outline-danger">
                    <i class="fas fa-download me-1"></i>Descargar
                </a>
            </div>
        </div>

        <!-- Reporte de Usuarios y Pedidos -->
        <div class="report-card">
            <i class="fas fa-users report-icon text-primary"></i>
            <h4>Usuarios y Pedidos</h4>
            <p class="text-muted">Información de usuarios y sus pedidos</p>
            <div class="btn-group-custom">
                <a href="{{ route('pdf.usuarios_pedidos', 1) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-eye me-1"></i>Ver PDF
                </a>
                <a href="{{ route('pdf.usuarios_pedidos', 2) }}" class="btn btn-outline-primary">
                    <i class="fas fa-download me-1"></i>Descargar
                </a>
            </div>
        </div>

        <!-- Reporte de Productos por Categoría -->
        <div class="report-card">
            <i class="fas fa-tags report-icon text-warning"></i>
            <h4>Productos por Categoría</h4>
            <p class="text-muted">Productos organizados por categorías</p>
            <div class="btn-group-custom">
                <a href="{{ route('pdf.productos_categoria', 1) }}" target="_blank" class="btn btn-warning">
                    <i class="fas fa-eye me-1"></i>Ver PDF
                </a>
                <a href="{{ route('pdf.productos_categoria', 2) }}" class="btn btn-outline-warning">
                    <i class="fas fa-download me-1"></i>Descargar
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
