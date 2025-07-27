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
    @stack('styles')

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

                <!-- Inputs escondidos -->
                <input type="hidden" id="shift_id" value="">
                <input type="hidden" id="shift_name" value="">
                <input type="hidden" id="shift_date" value="">
                <input type="hidden" id="shift_hour" value="">
                <input type="hidden" id="shift_status" value="">
                <input type="hidden" id="mysql_date" value="">
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p>© 2025 RamSua. Todos los derechos reservados. Licencia de suscripción.</p>
    </footer>

    <!-- Toast reutilizable para JS -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="mainToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="mainToastBody">
                    <!-- Mensaje aquí -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- ExcelJS for exporting to Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>

    <!-- PDF export using jsPDF and autoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</body>
</html>