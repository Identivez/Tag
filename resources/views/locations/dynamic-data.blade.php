{{--
/**
 * Vista para consultas dinámicas y actualización de datos geográficos.
 *
 * Esta plantilla permite realizar consultas AJAX para mostrar entidades por país
 * y actualizar nombres de entidades dinámicamente sin recargar la página.
 *
 * @extends layouts.app
 * @section title "Consulta Dinámica de Datos"
 * @uses LocationController::getEntities() Para obtener las entidades de un país
 * @uses LocationController::getEntityDetails() Para obtener detalles de una entidad
 * @uses LocationController::updateEntityName() Para actualizar el nombre de una entidad
 * @requires jQuery 3.6+
 */
--}}

@extends('layouts.app')

@section('title', 'Consulta Dinámica de Datos')

@section('content')
<div class="container">
    <h1>Consulta Dinámica de Datos</h1>

    {{-- Sección de consulta: Selector de país y botón de carga --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Consulta de entidades por país</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="search_country">Selecciona un país:</label>
                        <select id="search_country" class="form-control">
                            <option value="">-- Seleccione un país --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->CountryId }}">{{ $country->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button id="load_entities" class="btn btn-primary mt-2">Cargar entidades</button>
                </div>
            </div>
        </div>

        {{-- Sección de resultados: Muestra las entidades del país seleccionado --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Resultados</h3>
                    <span id="loading_indicator" style="display: none;">
                        <i class="fa fa-spinner fa-spin"></i> Cargando...
                    </span>
                </div>
                <div class="card-body">
                    <div id="results_container">
                        <p class="text-muted">Selecciona un país y haz clic en "Cargar entidades" para ver los resultados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de edición: Permite modificar el nombre de una entidad --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Actualizar nombre de entidad</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="edit_entity">Seleccionar entidad:</label>
                        <select id="edit_entity" class="form-control">
                            <option value="">-- Seleccione una entidad --</option>
                        </select>
                    </div>

                    <div id="edit_container" style="display: none;">
                        <div class="form-group">
                            <label for="entity_name">Nombre de la entidad:</label>
                            <input type="text" id="entity_name" class="form-control" />
                        </div>

                        <button id="update_entity" class="btn btn-warning">Actualizar nombre</button>
                    </div>

                    {{-- Contenedor para mostrar resultados de la actualización --}}
                    <div id="update_result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /**
     * Funcionalidad principal para la carga dinámica y edición de entidades.
     *
     * @requires jQuery
     */
    $(document).ready(function() {
        /**
         * Manejador para cargar entidades de un país seleccionado.
         * Realiza una petición AJAX al endpoint /locations/entities/{id}
         * y muestra los resultados en una tabla.
         */
        $('#load_entities').on('click', function() {
            const countryId = $('#search_country').val();
            const resultsContainer = $('#results_container');

            // Validación básica
            if (!countryId) {
                resultsContainer.html('<p class="text-danger">Selecciona un país primero.</p>');
                return;
            }

            // Mostrar indicador de carga
            $('#loading_indicator').show();

            // Hacer petición AJAX para obtener entidades
            $.ajax({
                url: `/locations/entities/${countryId}`,
                type: 'GET',
                success: function(data) {
                    // Ocultar indicador de carga
                    $('#loading_indicator').hide();

                    if (data.length > 0) {
                        // Crear tabla con resultados
                        let tableHtml = `
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        // Agregar filas con datos
                        $.each(data, function(index, entity) {
                            const statusBadge = entity.Status ?
                                '<span class="badge badge-success">Activo</span>' :
                                '<span class="badge badge-danger">Inactivo</span>';

                            tableHtml += `
                                <tr>
                                    <td>${entity.EntityId}</td>
                                    <td>${entity.Name}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                            `;

                            // También llenar el select para edición
                            $('#edit_entity').append(`<option value="${entity.EntityId}">${entity.Name}</option>`);
                        });

                        tableHtml += `
                                </tbody>
                            </table>
                        `;

                        resultsContainer.html(tableHtml);
                    } else {
                        resultsContainer.html('<p class="text-warning">No se encontraron entidades para este país.</p>');
                    }
                },
                error: function(error) {
                    // Ocultar indicador de carga
                    $('#loading_indicator').hide();

                    console.error('Error al cargar entidades:', error);
                    resultsContainer.html('<p class="text-danger">Error al cargar entidades. Inténtelo de nuevo.</p>');
                }
            });
        });

        /**
         * Manejador para cargar los detalles de una entidad al seleccionarla.
         * Realiza una petición GET a /locations/entity/{id}/details
         * y carga los datos en el formulario de edición.
         */
        $('#edit_entity').on('change', function() {
            const entityId = $(this).val();
            const editContainer = $('#edit_container');

            if (entityId) {
                // Hacer petición AJAX para obtener detalles de la entidad
                $.ajax({
                    url: `/locations/entity/${entityId}/details`,
                    type: 'GET',
                    success: function(data) {
                        // Llenar el campo de nombre
                        $('#entity_name').val(data.Name);

                        // Mostrar el contenedor de edición
                        editContainer.show();
                    },
                    error: function(error) {
                        console.error('Error al cargar detalles de la entidad:', error);
                        alert('Error al cargar detalles de la entidad');
                    }
                });
            } else {
                // Ocultar contenedor de edición si no hay entidad seleccionada
                editContainer.hide();
            }
        });

        /**
         * Manejador para actualizar el nombre de una entidad.
         * Realiza una petición PUT a /locations/entity/{id}/update
         * con el nuevo nombre y muestra el resultado.
         */
        $('#update_entity').on('click', function() {
            const entityId = $('#edit_entity').val();
            const newName = $('#entity_name').val();
            const updateResult = $('#update_result');

            // Validaciones básicas
            if (!entityId) {
                updateResult.html('<div class="alert alert-danger">Selecciona una entidad primero.</div>');
                return;
            }

            if (!newName.trim()) {
                updateResult.html('<div class="alert alert-danger">Ingresa un nombre válido.</div>');
                return;
            }

            // Hacer petición AJAX para actualizar el nombre
            $.ajax({
                url: `/locations/entity/${entityId}/update`,
                type: 'PUT',
                data: {
                    Name: newName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        updateResult.html(`
                            <div class="alert alert-success">
                                <h5>Nombre actualizado correctamente</h5>
                                <p><strong>Nombre anterior:</strong> ${response.oldName}</p>
                                <p><strong>Nombre nuevo:</strong> ${response.newName}</p>
                            </div>
                        `);

                        // Actualizar nombre en select
                        $(`#edit_entity option[value="${entityId}"]`).text(newName);
                    }
                },
                error: function(error) {
                    console.error('Error al actualizar nombre:', error);
                    updateResult.html(`
                        <div class="alert alert-danger">
                            Error al actualizar el nombre. Inténtelo de nuevo.
                        </div>
                    `);
                }
            });
        });
    });
</script>
@endsection
