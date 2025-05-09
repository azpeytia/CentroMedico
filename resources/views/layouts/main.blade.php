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
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    @vite(['resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header>
        <x-navbar />
    </header>

    <!-- Main Layout -->
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <!-- Sidebar -->
            <aside class="collapse d-md-block col-md-3" id="sidebarMenu">
                @include('partials.sidebar')
            </aside>

            <!-- Main Content -->
            <main class="main col-md-9">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p>© 2023 Cruz Roja. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>