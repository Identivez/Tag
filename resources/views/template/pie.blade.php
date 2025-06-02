<!-- Start Footer -->
<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">TAG & SOLE</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        Toluca, Estado de México, México
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:+52-722-123-4567">+52 722 123 4567</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:info@tagsole.com">info@tagsole.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Productos</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    @php
                        try {
                            $footerCategories = \App\Models\Category::take(7)->get();
                        } catch (\Exception $e) {
                            $footerCategories = collect();
                        }
                    @endphp
                    @forelse($footerCategories as $category)
                        <li><a class="text-decoration-none" href="{{ route('shop.category', $category->CategoryId) }}">{{ $category->Name }}</a></li>
                    @empty
                        <li><span class="text-muted">No hay categorías disponibles</span></li>
                    @endforelse
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Información</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="{{ route('home') }}">Inicio</a></li>
                    <li><a class="text-decoration-none" href="{{ route('shop.index') }}">Tienda</a></li>
                    <li><a class="text-decoration-none" href="{{ route('contact') }}">Contacto</a></li>
                    @auth
                        <li><a class="text-decoration-none" href="{{ route('favorites.user') }}">Favoritos</a></li>
                        <li><a class="text-decoration-none" href="{{ route('dashboard') }}">Mi Cuenta</a></li>
                    @else
                        <li><a class="text-decoration-none" href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a class="text-decoration-none" href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                    <li><a class="text-decoration-none" href="#" onclick="document.getElementById('newsletter-form').scrollIntoView();">Newsletter</a></li>
                </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>
            <div class="col-auto me-auto">
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://facebook.com/tagsole"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/tagsole"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/tagsole"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/company/tagsole"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-auto">
                <form id="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <label class="sr-only" for="subscribeEmail">Dirección de email</label>
                    <div class="input-group mb-2">
                        <input type="email" name="email" class="form-control bg-dark border-light" id="subscribeEmail" placeholder="Tu email para newsletter" required>
                        <button type="submit" class="input-group-text btn-success text-light">Suscribirse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; {{ date('Y') }} TAG & SOLE
                        | Tienda de Sneakers y Moda Urbana en Toluca, México
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- End Footer -->

<!-- Start Script -->
<script src="{{ asset('estilo/assets/js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ asset('estilo/assets/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('estilo/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('estilo/assets/js/templatemo.js') }}"></script>
<script src="{{ asset('estilo/assets/js/custom.js') }}"></script>

@yield('scripts')

<!-- Mensajes Flash -->
@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">¡Éxito!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif

<!-- End Script -->
</body>

</html>
