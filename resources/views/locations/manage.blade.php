{{--
/**
 * Vista para la gestión jerárquica de ubicaciones geográficas.
 *
 * Esta plantilla implementa una interfaz jerárquica país -> entidad -> municipio
 * con selects encadenados que cargan dinámicamente y permiten la actualización
 * del estado de activación de los municipios.
 *
 * @extends layouts.app
 * @section title "Gestión de Ubicaciones"
 * @uses LocationController::getEntities() Para cargar entidades de un país
 * @uses LocationController::getMunicipalities() Para cargar municipios de una entidad
 * @uses LocationController::getMunicipalityDetails() Para obtener detalles de un municipio
 * @uses LocationController::updateMunicipalityStatus() Para actualizar el estado de un municipio
 * @requires jQuery 3.6+
 */
--}}

@extends('layouts.app')

@section('title', 'Gestión de Ubicaciones')

@section('content')
<div class="container">
    <h1>Gestión de Ubicaciones</h1>

    <div class="row">
        {{-- Panel de selección jerárquica (país -> entidad -> municipio) --}}
        <div class="col-md-4">
            {{-- Selector de país - Primer nivel de la jerarquía --}}
            <div class="form-group">
                <label for="country_id">País:</label>
                <select id="country_id" class="form-control">
                    <option value="">-- Seleccione un país --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->CountryId }}">{{ $country->Name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Selector de entidad - Segundo nivel (depende del país) --}}
            <div class="form-group">
                <label for="entity_id">Entidad:</label>
                <select id="entity_id" class="form-control" disabled>
                    <option value="">-- Seleccione una entidad --</option>
                </select>
            </div>

            {{-- Selector de municipio - Tercer nivel (depende de la entidad) --}}
            <div class="form-group">
                <label for="municipality_id">Municipio:</label>
                <select id="municipality_id" class="form-control" disabled>
                    <option value="">-- Seleccione un municipio --</option>
                </select>
            </div>
        </div>

        {{-- Panel de detalles y edición --}}
        <div class="col-md-8">
            <div id="details_container" class="card">
                <div class="card-header">
                    <h2>Detalles de ubicación</h2>
                </div>
                <div class="card-body">
                    <p>Selecciona un país, entidad y municipio para ver los detalles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /**
     * Gestión interactiva de ubicaciones geográficas jerárquicas.
     *
     * Este script implementa una interfaz de navegación y edición jerárquica
     * para ubicaciones: país -> entidad -> municipio, con carga dinámica
     * de selects dependientes y funcionalidad para actualizar el estado
     * de los municipios.
     *
     * @requires jQuery 3.6+
     */
    $(document).ready(function() {
        /**
         * Manejador para cargar entidades al cambiar el país seleccionado.
         *
         * Al seleccionar un país, carga las entidades correspondientes mediante AJAX
         * y reinicia los selects de entidades y municipios dependientes.
         */
        $('#country_id').on('change', function() {
            const countryId = $(this).val();
            const entitySelect = $('#entity_id');
            const municipalitySelect = $('#municipality_id');

            // Limpiar y deshabilitar selects dependientes
            entitySelect.html('<option value="">-- Seleccione una entidad --</option>').prop('disabled', true);
            municipalitySelect.html('<option value="">-- Seleccione un municipio --</option>').prop('disabled', true);
            $('#details_container .card-body').html('<p>Selecciona un país, entidad y municipio para ver los detalles.</p>');

            if (countryId) {
                // Hacer petición AJAX para obtener entidades
                $.ajax({
                    url: `/locations/entities/${countryId}`,
                    type: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            // Agregar opciones al select de entidades
                            $.each(data, function(index, entity) {
                                entitySelect.append(`<option value="${entity.EntityId}">${entity.Name}</option>`);
                            });

                            // Habilitar select de entidades
                            entitySelect.prop('disabled', false);
                        } else {
                            entitySelect.html('<option value="">No hay entidades disponibles</option>');
                        }
                    },
                    error: function(error) {
                        console.error('Error al cargar entidades:', error);
                        alert('Error al cargar entidades');
                    }
                });
            }
        });

        /**
         * Manejador para cargar municipios al cambiar la entidad seleccionada.
         *
         * Al seleccionar una entidad, carga los municipios correspondientes mediante AJAX
         * y reinicia el select de municipios y el panel de detalles.
         */
        $('#entity_id').on('change', function() {
            const entityId = $(this).val();
            const municipalitySelect = $('#municipality_id');

            // Limpiar y deshabilitar select de municipios
            municipalitySelect.html('<option value="">-- Seleccione un municipio --</option>').prop('disabled', true);
            $('#details_container .card-body').html('<p>Selecciona un municipio para ver los detalles.</p>');

            if (entityId) {
                // Hacer petición AJAX para obtener municipios
                $.ajax({
                    url: `/locations/municipalities/${entityId}`,
                    type: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            // Agregar opciones al select de municipios
                            $.each(data, function(index, municipality) {
                                municipalitySelect.append(`<option value="${municipality.MunId}">${municipality.Name}</option>`);
                            });

                            // Habilitar select de municipios
                            municipalitySelect.prop('disabled', false);
                        } else {
                            municipalitySelect.html('<option value="">No hay municipios disponibles</option>');
                        }
                    },
                    error: function(error) {
                        console.error('Error al cargar municipios:', error);
                        alert('Error al cargar municipios');
                    }
                });
            }
        });

        /**
         * Manejador para cargar detalles del municipio seleccionado.
         *
         * Al seleccionar un municipio, carga los detalles completos mediante AJAX,
         * incluyendo información sobre su entidad y país, y genera una interfaz
         * para modificar su estado de activación.
         */
        $('#municipality_id').on('change', function() {
            const municipalityId = $(this).val();
            const detailsContainer = $('#details_container .card-body');

            if (municipalityId) {
                // Hacer petición AJAX para obtener detalles del municipio
                $.ajax({
                    url: `/locations/municipality/${municipalityId}/details`,
                    type: 'GET',
                    success: function(data) {
                        // Construir HTML con los detalles
                        let statusBadge = data.Status ?
                            '<span class="badge badge-success">Activo</span>' :
                            '<span class="badge badge-danger">Inactivo</span>';

                        // Generar interfaz de detalle y edición
                        let html = `
                            <div class="municipality-details">
                                <h3>${data.Name}</h3>
                                <p><strong>ID:</strong> ${data.MunId}</p>
                                <p><strong>Entidad:</strong> ${data.entity.Name}</p>
                                <p><strong>País:</strong> ${data.entity.country.Name}</p>
                                <p><strong>Estado:</strong> ${statusBadge}</p>

                                <div class="form-group">
                                    <label>Cambiar estado:</label>
                                    <div class="d-flex">
                                        <select id="status_select" class="form-control mr-2">
                                            <option value="1" ${data.Status ? 'selected' : ''}>Activo</option>
                                            <option value="0" ${!data.Status ? 'selected' : ''}>Inactivo</option>
                                        </select>
                                        <button id="update_status" class="btn btn-primary" data-mun-id="${data.MunId}">Actualizar</button>
                                    </div>
                                </div>

                                <div id="update_result" class="mt-3"></div>
                            </div>
                        `;

                        detailsContainer.html(html);

                        /**
                         * Manejador para actualizar el estado de un municipio.
                         *
                         * Envía el nuevo estado mediante AJAX al servidor y
                         * actualiza la interfaz con el resultado de la operación.
                         */
                        $('#update_status').on('click', function() {
                            const munId = $(this).data('mun-id');
                            const newStatus = $('#status_select').val();

                            // Hacer petición AJAX para actualizar el estado
                            $.ajax({
                                url: `/locations/municipality/${munId}/status`,
                                type: 'PUT',
                                data: {
                                    Status: newStatus,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Preparar mensajes de retroalimentación
                                        const oldStatusText = response.oldStatus ? 'Activo' : 'Inactivo';
                                        const newStatusText = response.newStatus ? 'Activo' : 'Inactivo';

                                        // Mostrar mensaje de éxito
                                        $('#update_result').html(`
                                            <div class="alert alert-success">
                                                <h5>Estado actualizado correctamente</h5>
                                                <p><strong>Estado anterior:</strong> ${oldStatusText}</p>
                                                <p><strong>Estado nuevo:</strong> ${newStatusText}</p>
                                            </div>
                                        `);

                                        // Actualizar badge de estado en la interfaz
                                        const newBadge = response.newStatus ?
                                            '<span class="badge badge-success">Activo</span>' :
                                            '<span class="badge badge-danger">Inactivo</span>';

                                        $('.municipality-details p:contains("Estado:")').html(`<strong>Estado:</strong> ${newBadge}`);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error al actualizar estado:', error);
                                    $('#update_result').html(`
                                        <div class="alert alert-danger">
                                            Error al actualizar el estado. Inténtelo de nuevo.
                                        </div>
                                    `);
                                }
                            });
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar detalles del municipio:', error);
                        detailsContainer.html('<p class="text-danger">Error al cargar los detalles del municipio.</p>');
                    }
                });
            } else {
                detailsContainer.html('<p>Selecciona un municipio para ver los detalles.</p>');
            }
        });
    });
</script>
@endsection
