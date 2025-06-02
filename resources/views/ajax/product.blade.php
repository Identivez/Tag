@extends('layouts.app')

@section('title','Gestión AJAX de Productos')
@section('content')
<div class="container">
    <h2>Gestión de Stock (AJAX)</h2>
    <div id="productTable"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    loadTable();

    function loadTable() {
        fetch('{{ route("ajax.products.list") }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('productTable').innerHTML = html;
                attachUpdateHandlers();
            });
    }

    function attachUpdateHandlers() {
        document.querySelectorAll('.update-stock-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('{{ route("ajax.products.updateStock") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) loadTable();
                });
            });
        });
    }
});
</script>
@endsection
