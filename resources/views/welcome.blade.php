<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about') }}">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact') }}">Contacto</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Más
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('/services') }}">Servicios</a></li>
                                <li><a class="dropdown-item" href="{{ url('/donate') }}">Donar</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Authentication Links -->
                    @if (Route::has('login'))
                        <div class="d-flex align-items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary me-2">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">Registro</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mt-4">
        <h1 class="text-center">Bienvenido a la Cruz Roja</h1>
        <p class="text-center">Estamos aquí para ayudar.</p>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body card-custom-bg">
                        <h5 class="card-title">¿Cómo puedes ayudar?</h5>
                        <p class="card-text">Puedes hacer una donación, registrarte como voluntario o simplemente informarte sobre nuestros servicios.</p>
                        <a href="{{ url('/donate') }}" class="btn btn-primary">Donar</a>
                        <a href="{{ url('/volunteer') }}" class="btn btn-secondary">Hazte Voluntario</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/news1.jpg') }}" class="card-img-top" alt="Noticia 1">
                    <div class="card-body">
                        <h5 class="card-title">Noticia 1</h5>
                        <p class="card-text">Descripción breve de la noticia 1.</p>
                        <a href="#" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/news2.jpg') }}" class="card-img-top" alt="Noticia 2">
                    <div class="card-body">
                        <h5 class="card-title">Noticia 2</h5>
                        <p class="card-text">Descripción breve de la noticia 2.</p>
                        <a href="#" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/news3.jpg') }}" class="card-img-top" alt="Noticia 3">
                    <div class="card-body">
                        <h5 class="card-title">Noticia 3</h5>
                        <p class="card-text">Descripción breve de la noticia 3.</p>
                        <a href="#" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>© 2023 Cruz Roja. Todos los derechos reservados. <a href="{{ url('/privacy') }}">Política de privacidad</a></p>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>