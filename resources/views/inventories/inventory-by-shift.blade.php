@extends('layouts.main')

@section('title', 'Inventario por turno')

@section('content')
    <div class="container my-3" id="inventory-by-shift">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-10">
                <div class="card text-center shadow">
                    <div class="card-header">
                        <h3>{{ __('Inventario por turno') }}</h3>
                        <div class="card-tools">
                            <button id="btnExportExcel" class="btn btn-success">Exportar a Excel</button>
                            <button id="btnExportPDF" class="btn btn-danger">Exportar a PDF</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> <!-- Asegura desplazamiento horizontal en pantallas pequeñas -->
                            <table id="inventoryTable" class="table table-bordered table-striped table-hover table-sm">
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-column flex-sm-row justify-content-between text-center text-sm-start">
                        <div>Usuario(a): {{ Auth::user()->name }}</div>
                        <div>Hora: <span id="hour"></span> | Fecha: <span id="date"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/inventory-by-shift.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/inventory-by-shift.css') }}">
@endpush