@extends('layouts.app')

@section('title','Selector de Ubicación')
@section('content')
<div class="container">
    <h2>Seleccionar Ubicación</h2>

    <div class="form-group">
        <label for="pais">País:</label>
        <select id="pais" class="form-control">
            <option value="">Selecciona un país</option>
            @foreach($paises as $pais)
                <option value="{{ $pais->CountryId }}">{{ $pais->Name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="entidad">Entidad:</label>
        <select id="entidad" class="form-control">
            <option value="">Selecciona una entidad</option>
        </select>
    </div>

    <div class="form-group">
        <label for="municipio">Municipio:</label>
        <select id="municipio" class="form-control">
            <option value="">Selecciona un municipio</option>
        </select>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('pais').addEventListener('change', function () {
    const paisId = this.value;
    fetch(`/ajax/entities/${paisId}`)
        .then(res => res.json())
        .then(data => {
            const entidadSelect = document.getElementById('entidad');
            entidadSelect.innerHTML = '<option value="">Selecciona una entidad</option>';
            data.forEach(entidad => {
                entidadSelect.innerHTML += `<option value="${entidad.EntityId}">${entidad.Name}</option>`;
            });

            document.getElementById('municipio').innerHTML = '<option value="">Selecciona un municipio</option>';
        });
});

document.getElementById('entidad').addEventListener('change', function () {
    const entidadId = this.value;
    fetch(`/ajax/municipalities/${entidadId}`)
        .then(res => res.json())
        .then(data => {
            const municipioSelect = document.getElementById('municipio');
            municipioSelect.innerHTML = '<option value="">Selecciona un municipio</option>';
            data.forEach(mun => {
                municipioSelect.innerHTML += `<option value="${mun.MunId}">${mun.Name}</option>`;
            });
        });
});
</script>
@endpush
