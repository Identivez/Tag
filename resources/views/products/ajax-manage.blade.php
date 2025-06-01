```blade
@extends('layouts.app')

@section('title', 'Gestión de Productos por Categoría')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Gestión de Productos por Categoría</h1>

    <div class="row mb-5">
        <div class="col-md-10 mx-auto mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title h5 mb-0">Consulta de productos por categoría</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Selecciona una categoría:</label>
                        <select id="category_id" class="form-control" onchange="buscarProductos(this.value);">
                            <option value="">-- Seleccione una categoría --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->CategoryId }}">{{ $category->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="resultado_categoria" class="mt-4">
                        <p class="text-muted">Selecciona una categoría para ver los productos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-product-form">
                        <input type="hidden" id="edit_product_id">

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="edit_name" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_price" class="form-label">Precio:</label>
                            <input type="number" class="form-control" id="edit_price" step="0.01" min="0" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_stock" class="form-label">Stock:</label>
                            <input type="number" class="form-control" id="edit_stock" min="0" required>
                        </div>
                    </form>

                    <div id="update_result" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function buscarProductos(categoryId) {
        if (!categoryId) {
            $('#resultado_categoria').html('<p class="text-danger">Selecciona una categoría primero.</p>');
            return;
        }

        // Mostrar mensaje de carga
        $('#resultado_categoria').html('<p><i class="fa fa-spinner fa-spin"></i> Cargando productos...</p>');

        // Hacer petición AJAX
        $.ajax({
            type: 'GET',
            url: '/productos/buscar/' + categoryId,
            success: function(data) {
                $('#resultado_categoria').html(data);
            },
            error: function(error) {
                console.error('Error al buscar productos:', error);
                $('#resultado_categoria').html('<p class="text-danger">Error al cargar productos. Inténtelo de nuevo.</p>');
            }
        });
    }

    function incrementarStock(productId, categoryId) {
        // Hacer petición AJAX silenciosa
        $.ajax({
            type: 'GET',
            url: '/productos/incrementar/' + productId + '/' + categoryId,
            success: function(data) {
                // Recargar la lista de productos sin mostrar el mensaje de éxito
                buscarProductos(categoryId);
            },
            error: function(error) {
                console.error('Error al incrementar stock:', error);
                $('#resultado_categoria').html('<p class="text-danger">Error al actualizar stock. Inténtelo de nuevo.</p>');
            }
        });
    }

    function decrementarStock(productId, categoryId) {
        // Hacer petición AJAX silenciosa
        $.ajax({
            type: 'GET',
            url: '/productos/decrementar/' + productId + '/' + categoryId,
            success: function(data) {
                // Recargar la lista de productos sin mostrar el mensaje de éxito
                buscarProductos(categoryId);
            },
            error: function(error) {
                console.error('Error al decrementar stock:', error);
                $('#resultado_categoria').html('<p class="text-danger">Error al actualizar stock. Inténtelo de nuevo.</p>');
            }
        });
    }

    function editarProducto(productId) {
        // Limpiar resultados anteriores
        $('#update_result').html('');

        // Hacer petición AJAX para obtener datos del producto
        $.ajax({
            type: 'GET',
            url: '/productos/obtener/' + productId,
            success: function(response) {
                if (response.success) {
                    const product = response.product;

                    // Llenar el formulario
                    $('#edit_product_id').val(product.ProductId);
                    $('#edit_name').val(product.Name);
                    $('#edit_price').val(product.Price);
                    $('#edit_stock').val(product.Stock);

                    // Mostrar el modal
                    $('#editProductModal').modal('show');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(error) {
                console.error('Error al obtener producto:', error);
                alert('Error al obtener datos del producto. Inténtelo de nuevo.');
            }
        });
    }

    function guardarCambios() {
        const productId = $('#edit_product_id').val();
        const data = {
            Name: $('#edit_name').val(),
            Price: $('#edit_price').val(),
            Stock: $('#edit_stock').val(),
            _token: '{{ csrf_token() }}'
        };

        // Validar datos
        if (!data.Name || !data.Price || !data.Stock) {
            $('#update_result').html('<div class="alert alert-danger">Todos los campos son obligatorios.</div>');
            return;
        }

        // Mostrar mensaje de carga
        $('#update_result').html('<p><i class="fa fa-spinner fa-spin"></i> Guardando cambios...</p>');

        // Hacer petición AJAX
        $.ajax({
            type: 'PUT',
            url: '/productos/actualizar/' + productId,
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#update_result').html(`
                        <div class="alert alert-success">
                            <h5>Producto actualizado correctamente</h5>
                            <p><strong>Nombre anterior:</strong> ${response.oldProduct.Name}</p>
                            <p><strong>Nombre nuevo:</strong> ${response.newProduct.Name}</p>
                            <p><strong>Precio anterior:</strong> ${response.oldProduct.Price}</p>
                            <p><strong>Precio nuevo:</strong> ${response.newProduct.Price}</p>
                            <p><strong>Stock anterior:</strong> ${response.oldProduct.Stock}</p>
                            <p><strong>Stock nuevo:</strong> ${response.newProduct.Stock}</p>
                        </div>
                    `);

                    // Actualizar los productos si hay una categoría seleccionada
                    if ($('#category_id').val()) {
                        buscarProductos($('#category_id').val());
                    }
                } else {
                    $('#update_result').html(`
                        <div class="alert alert-danger">
                            Error: ${response.message}
                        </div>
                    `);
                }
            },
            error: function(error) {
                console.error('Error al actualizar producto:', error);
                $('#update_result').html('<div class="alert alert-danger">Error al actualizar producto. Inténtelo de nuevo.</div>');
            }
        });
    }
</script>
@endsection

<style>
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }

    th, td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .btn {
        margin: 2px;
    }

    /* Asegúrate de que las cards tengan altura mínima */
    .card {
        min-height: 300px;
    }

    /* Agrega esto para los resultados sean elementos independientes */
    #resultado_categoria, #resultado_proveedor {
        min-height: 150px;
    }
</style>


