<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cruz Roja')</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/quitar.css') }}" rel="stylesheet">

    @vite(['resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    {{-- <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    Cruz Roja
                </a>
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
                        @if (Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                                    <li><a class="dropdown-item" href="{{ url('/profile') }}">Perfil</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/logout') }}">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">Iniciar sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/register') }}">Registrarse</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header> --}}
    {{-- <main class="container my-5">
        @yield('content')
    </main>
    <div class="container-fluid bg-light py-5 text-center">
        <h2 class="display-4">Únete a nuestra causa</h2>
        <p class="lead">Con tu ayuda, podemos hacer la diferencia.</p>
        <a href="{{ url('/volunteer') }}" class="btn btn-primary btn-lg">Hazte voluntario</a>
    </div>
    <div class="container my-5">
        <h2 class="text-center">Últimas Noticias</h2>
        <div class="row">
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
    </div>
    <div class="container-fluid bg-light py-5 text-center">
        <h2 class="display-4">Contáctanos</h2>
        <p class="lead">Estamos aquí para ayudarte.</p>
        <a href="{{ url('/contact') }}" class="btn btn-primary btn-lg">Contáctanos</a>
    </div>
    <div class="container my-5">
        <h2 class="text-center">Síguenos en Redes Sociales</h2>
        <div class="text-center">
            <a href="#" class="btn btn-primary mx-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="btn btn-primary mx-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="btn btn-primary mx-2"><i class="bi bi-instagram"></i></a>
            <a href="#" class="btn btn-primary mx-2"><i class="bi bi-linkedin"></i></a>
        </div>
    </div> --}}
    <!-- Main Layout -->
    {{-- <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 bg-light sidebar">
                <div class="pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">
                                <i class="bi bi-house-door"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about') }}">
                                <i class="bi bi-info-circle"></i> Sobre Nosotros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/services') }}">
                                <i class="bi bi-briefcase"></i> Servicios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/donate') }}">
                                <i class="bi bi-heart"></i> Donar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact') }}">
                                <i class="bi bi-envelope"></i> Contacto
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Bienvenido</h1>
                </div>
                <p>Este es el contenido principal de la página. Aquí puedes agregar cualquier información relevante.</p>
            </main>
        </div>
    </div> --}}
    <!-- Footer -->
    {{-- <footer class="footer">
        <div class="container-fluid bg-light text-center py-3">
            <p class="mb-0">© 2023 Cruz Roja. Todos los derechos reservados.</p>
        </div>
    </footer> --}}

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
