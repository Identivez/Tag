<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Sneakers Market</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
  <a class="nav-link" href="{{ url('/sneakers') }}">Sneakers</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ url('/accesorios') }}">Accesorios</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ url('/moda') }}">Moda</a>
</li>

                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Vender</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
