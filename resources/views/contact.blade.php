@extends('template.master')

@section('contenido_central')

<!-- Start Content Page -->
<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">Contáctanos</h1>
        <p>
            ¿Tienes alguna pregunta sobre nuestros productos o necesitas ayuda?
            Estamos aquí para ayudarte. Escríbenos y te responderemos lo antes posible.
        </p>
    </div>
</div>

<!-- Start Map -->
<div id="mapid" style="width: 100%; height: 300px;"></div>

<!-- Start Contact -->
<div class="container py-5">
    <div class="row py-5">
        <!-- Información de contacto -->
        <div class="col-md-4 mb-4">
            <div class="bg-white shadow-sm rounded p-4 h-100">
                <h4 class="mb-4">Información de Contacto</h4>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-map-marker-alt text-success me-3"></i>
                        <strong>Dirección</strong>
                    </div>
                    <p class="ms-4 text-muted mb-0">
                        Centro Comercial Galerías Toluca<br>
                        Toluca, Estado de México<br>
                        México 50120
                    </p>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone text-success me-3"></i>
                        <strong>Teléfono</strong>
                    </div>
                    <p class="ms-4 text-muted mb-0">
                        <a href="tel:+52-722-123-4567" class="text-decoration-none">+52 722 123 4567</a>
                    </p>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-envelope text-success me-3"></i>
                        <strong>Email</strong>
                    </div>
                    <p class="ms-4 text-muted mb-0">
                        <a href="mailto:info@tagsole.com" class="text-decoration-none">info@tagsole.com</a>
                    </p>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-clock text-success me-3"></i>
                        <strong>Horarios</strong>
                    </div>
                    <div class="ms-4 text-muted">
                        <p class="mb-1">Lunes - Viernes: 10:00 AM - 9:00 PM</p>
                        <p class="mb-1">Sábados: 10:00 AM - 10:00 PM</p>
                        <p class="mb-0">Domingos: 11:00 AM - 8:00 PM</p>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-share-alt text-success me-3"></i>
                        <strong>Síguenos</strong>
                    </div>
                    <div class="ms-4">
                        <a href="https://facebook.com/tagsole" class="text-decoration-none me-3" target="_blank">
                            <i class="fab fa-facebook-f text-primary"></i>
                        </a>
                        <a href="https://instagram.com/tagsole" class="text-decoration-none me-3" target="_blank">
                            <i class="fab fa-instagram text-danger"></i>
                        </a>
                        <a href="https://twitter.com/tagsole" class="text-decoration-none me-3" target="_blank">
                            <i class="fab fa-twitter text-info"></i>
                        </a>
                        <a href="https://linkedin.com/company/tagsole" class="text-decoration-none" target="_blank">
                            <i class="fab fa-linkedin text-primary"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="col-md-8">
            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="mb-4">Envíanos un Mensaje</h4>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" id="contact-form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" placeholder="Tu nombre completo"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="tu@email.com"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Asunto <span class="text-danger">*</span></label>
                        <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="Consulta sobre productos" {{ old('subject') == 'Consulta sobre productos' ? 'selected' : '' }}>
                                Consulta sobre productos
                            </option>
                            <option value="Información de envío" {{ old('subject') == 'Información de envío' ? 'selected' : '' }}>
                                Información de envío
                            </option>
                            <option value="Problema con mi pedido" {{ old('subject') == 'Problema con mi pedido' ? 'selected' : '' }}>
                                Problema con mi pedido
                            </option>
                            <option value="Devoluciones y cambios" {{ old('subject') == 'Devoluciones y cambios' ? 'selected' : '' }}>
                                Devoluciones y cambios
                            </option>
                            <option value="Sugerencias" {{ old('subject') == 'Sugerencias' ? 'selected' : '' }}>
                                Sugerencias
                            </option>
                            <option value="Otro" {{ old('subject') == 'Otro' ? 'selected' : '' }}>
                                Otro
                            </option>
                        </select>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror"
                                  id="message" name="message" placeholder="Escribe tu mensaje aquí..."
                                  rows="6" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Mínimo 10 caracteres. Mientras más detalles nos proporciones, mejor podremos ayudarte.
                        </div>
                    </div>

                    <!-- Campo honeypot para prevenir spam -->
                    <input type="text" name="website" style="display: none;" tabindex="-1" autocomplete="off">

                    <div class="row">
                        <div class="col text-end mt-2">
                            <button type="submit" class="btn btn-success btn-lg px-4" id="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h4 class="mb-4">Preguntas Frecuentes</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-success">¿Hacen envíos a toda la República?</h6>
                            <p class="text-muted mb-0">Sí, realizamos envíos a todo México. Los tiempos de entrega varían según la ubicación.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-success">¿Puedo cambiar mi pedido?</h6>
                            <p class="text-muted mb-0">Aceptamos cambios y devoluciones dentro de los 30 días posteriores a la compra.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-success">¿Cómo puedo rastrear mi pedido?</h6>
                            <p class="text-muted mb-0">Una vez enviado tu pedido, recibirás un número de rastreo por email.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-success">¿Ofrecen garantía en los productos?</h6>
                            <p class="text-muted mb-0">Todos nuestros productos cuentan con garantía del fabricante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Contact -->

@endsection

@section('scripts')
<!-- Mapa con Leaflet -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar mapa - Coordenadas de Toluca, México
    var mymap = L.map('mapid').setView([19.2926, -99.6568], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors | TAG & SOLE'
    }).addTo(mymap);

    // Agregar marcador para TAG & SOLE
    L.marker([19.2926, -99.6568]).addTo(mymap)
        .bindPopup("<b>TAG & SOLE</b><br />Tienda de Sneakers y Moda Urbana<br />Toluca, Estado de México")
        .openPopup();

    // Deshabilitar scroll del mapa
    mymap.scrollWheelZoom.disable();
    mymap.touchZoom.disable();

    // Validación del formulario
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', function(e) {
        // Cambiar texto del botón
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        submitBtn.disabled = true;
    });

    // Contador de caracteres para el mensaje
    const messageTextarea = document.getElementById('message');
    const charCount = document.createElement('div');
    charCount.className = 'form-text text-end';
    charCount.style.fontSize = '0.875rem';
    messageTextarea.parentNode.appendChild(charCount);

    function updateCharCount() {
        const current = messageTextarea.value.length;
        const min = 10;
        charCount.textContent = `${current} caracteres`;

        if (current < min) {
            charCount.className = 'form-text text-end text-danger';
            charCount.textContent = `${current} caracteres (mínimo ${min})`;
        } else {
            charCount.className = 'form-text text-end text-muted';
        }
    }

    messageTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Llamada inicial
});
