@extends('template.master')

@section('contenido_central')

<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('estilo/assets/img/banner_img_01.jpg') }}" alt="TAG & SOLE Sneakers">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1 class="h1 text-success"><b>TAG & SOLE</b></h1>
                            <h3 class="h2">Tu Tienda de Sneakers y Moda Urbana</h3>
                            <p>
                                Descubre la mejor colección de sneakers, ropa urbana y accesorios en Toluca.
                                En TAG & SOLE encontrarás las marcas más exclusivas y los estilos más frescos
                                para expresar tu personalidad única.
                            </p>
                            <p>
                                <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg">Ver Tienda</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('estilo/assets/img/banner_img_02.jpg') }}" alt="Nuevas Colecciones">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Nuevas Colecciones</h1>
                            <h3 class="h2">Últimas tendencias en moda urbana</h3>
                            <p>
                                Mantente al día con las últimas tendencias. Cada semana agregamos nuevos productos
                                de las marcas más reconocidas del street style y la cultura sneaker.
                            </p>
                            <p>
                                <a href="{{ route('shop.index') }}?sort=newest" class="btn btn-success btn-lg">Ver Novedades</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('estilo/assets/img/banner_img_03.jpg') }}" alt="Ofertas Especiales">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Ofertas Especiales</h1>
                            <h3 class="h2">Descuentos exclusivos para ti</h3>
                            <p>
                                Aprovecha nuestras ofertas especiales y descuentos exclusivos.
                                Suscríbete a nuestro newsletter para recibir las mejores promociones.
                            </p>
                            <p>
                                <a href="{{ route('shop.index') }}?on_sale=1" class="btn btn-success btn-lg">Ver Ofertas</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>
<!-- End Banner Hero -->

<!-- Start Categories of The Month -->
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Categorías Destacadas</h1>
            <p>
                Explora nuestras categorías más populares y encuentra exactamente lo que buscas
                para completar tu estilo urbano.
            </p>
        </div>
    </div>
    <div class="row">
        @php
            try {
                $featuredCategories = \App\Models\Category::take(3)->get();
            } catch (\Exception $e) {
                $featuredCategories = collect();
            }
        @endphp
        @forelse($featuredCategories as $category)
        <div class="col-12 col-md-4 p-5 mt-3">
            <a href="{{ route('shop.category', $category->CategoryId) }}">
                <img src="{{ asset('estilo/assets/img/category_img_0' . ($loop->iteration) . '.jpg') }}" class="rounded-circle img-fluid border">
            </a>
            <h5 class="text-center mt-3 mb-3">{{ $category->Name }}</h5>
            <p class="text-center">
                <a class="btn btn-success" href="{{ route('shop.category', $category->CategoryId) }}">Ver Productos</a>
            </p>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h4>Categorías próximamente</h4>
                <p class="text-muted">Estamos organizando nuestras categorías para ti.</p>
            </div>
        </div>
        @endforelse
    </div>
</section>
<!-- End Categories of The Month -->

<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Productos Destacados</h1>
                <p>
                    Descubre nuestra selección de productos más populares y mejor valorados
                    por nuestra comunidad de sneakerheads.
                </p>
            </div>
        </div>
        <div class="row">
            @php
                $featuredProducts = collect();
                try {
                    $featuredProducts = \App\Models\Product::with(['category', 'images'])
                        ->orderBy('CreatedAt', 'desc')
                        ->take(3)
                        ->get();

                    // Si no hay productos con CreatedAt, usar ProductId como fallback
                    if ($featuredProducts->isEmpty()) {
                        $featuredProducts = \App\Models\Product::with(['category', 'images'])
                            ->orderBy('ProductId', 'desc')
                            ->take(3)
                            ->get();
                    }
                } catch (\Exception $e) {
                    // Si hay error, mantener colección vacía
                }
            @endphp

            @forelse($featuredProducts as $product)
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="{{ route('shop.product', $product->ProductId) }}">
                        @if($product->images && $product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->ImageFileName) }}" class="card-img-top" alt="{{ $product->Name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('estilo/assets/img/feature_prod_0' . (($loop->iteration - 1) % 3 + 1) . '.jpg') }}" class="card-img-top" alt="{{ $product->Name }}" style="height: 250px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="card-body">
                        <ul class="list-unstyled d-flex justify-content-between">
                            <li>
                                @php
                                    $rating = 0;
                                    $reviewCount = 0;
                                    try {
                                        $rating = $product->reviews && $product->reviews->count() > 0 ? $product->reviews->avg('Rating') : 0;
                                        $reviewCount = $product->reviews ? $product->reviews->count() : 0;
                                    } catch (\Exception $e) {
                                        // Si hay error, mantener valores por defecto
                                    }
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="text-warning fa fa-star"></i>
                                    @else
                                        <i class="text-muted fa fa-star"></i>
                                    @endif
                                @endfor
                            </li>
                            <li class="text-muted text-right">${{ number_format($product->Price, 2) }}</li>
                        </ul>
                        <a href="{{ route('shop.product', $product->ProductId) }}" class="h2 text-decoration-none text-dark">{{ $product->Name }}</a>
                        <p class="card-text">
                            {{ Str::limit($product->Description ?? 'Producto de alta calidad disponible en TAG & SOLE.', 100) }}
                        </p>
                        <p class="text-muted">
                            @if($reviewCount > 0)
                                Reseñas ({{ $reviewCount }})
                            @else
                                Sin reseñas aún
                            @endif
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ route('shop.product', $product->ProductId) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                @auth
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="ProductId" value="{{ $product->ProductId }}">
                                        <input type="hidden" name="Quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-success"
                                                @if($product->Stock <= 0) disabled @endif>
                                            @if($product->Stock > 0)
                                                Agregar
                                            @else
                                                Sin Stock
                                            @endif
                                        </button>
                                    </form>
                                @endauth
                            </div>
                            @if($product->category)
                                <small class="text-muted">{{ $product->category->Name }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4>Próximamente nuevos productos</h4>
                    <p class="text-muted">Estamos preparando una increíble colección para ti.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-success">Explorar Catálogo</a>
                </div>
            </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg">Ver Todos los Productos</a>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Product -->

@endsection
