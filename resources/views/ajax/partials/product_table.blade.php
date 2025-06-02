<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>Stock</th><th>Actualizar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
            <tr>
                <td>{{ $p->ProductId }}</td>
                <td>{{ $p->Name }}</td>
                <td>{{ $p->Stock }}</td>
                <td>
                    <form class="update-stock-form">
                        <input type="hidden" name="product_id" value="{{ $p->ProductId }}">
                        <input type="number" name="stock" value="{{ $p->Stock }}" min="0" class="form-control" style="width: 80px; display: inline;">
                        <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
