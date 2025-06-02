@extends('layouts.app')

@section('title', 'Contáctanos')

@section('contenido_central')
<div class="container-fluid bg-light py-5 text-center">
    <h1 class="h1">Contáctanos</h1>
    <p>¿Tienes dudas sobre nuestros productos? Escríbenos y te responderemos pronto.</p>
</div>

<!-- Mapa -->
<div id="mapid" style="width: 100%; height: 300px;"></div>

<!-- Contacto -->
<div class="container py-5">
    <div class="row">
        <!-- Info -->
        <div class="col-md-4 mb-4">
            <div class="bg-white p-4 shadow rounded">
                <h4>Información</h4>
                <p><strong>Dirección:</strong><br>Galerías Toluca, Edo. de México</p>
                <p><strong>Teléfono:</strong><br><a href="tel:+527221234567">+52 722 123 4567</a></p>
                <p><strong>Email:</strong><br><a href="mailto:info@tagsole.com">info@tagsole.com</a></p>
                <p><strong>Horario:</strong><br>Lun a Sáb 10am - 9pm<br>Dom 11am - 8pm</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="col-md-8">
            <div class="bg-white p-4 shadow rounded">
                <h4>Formulario de contacto</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Nombre *</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label>Asunto *</label>
                        <select name="subject" class="form-select" required>
                            <option value="">-- Selecciona --</option>
                            <option value="Consulta" {{ old('subject') == 'Consulta' ? 'selected' : '' }}>Consulta</option>
                            <option value="Pedido" {{ old('subject') == 'Pedido' ? 'selected' : '' }}>Pedido</option>
                            <option value="Otro" {{ old('subject') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Mensaje *</label>
                        <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    <input type="text" name="website" style="display:none;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i> Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('mapid').setView([19.2926, -99.6568], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        L.marker([19.2926, -99.6568]).addTo(map)
            .bindPopup("TAG & SOLE<br>Galerías Toluca")
            .openPopup();
    });
</script>
@endsection
