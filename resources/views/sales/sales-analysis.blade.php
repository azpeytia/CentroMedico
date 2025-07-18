@extends('layouts.main')

@section('title', 'Análisis de Ventas')

@section('content')
    <div class="container" id="sales-analysis">
        <h3>{{ __('Análisis de Ventas') }}</h3>

        <div class="mb-4">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active">Turno</button>
                <button type="button" class="btn btn-outline-primary">Día</button>
                <button type="button" class="btn btn-outline-primary">Semana</button>
                <button type="button" class="btn btn-outline-primary">Mes</button>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Ventas por Turno</h6>
                        <h4 class="fw-bold text-primary" id="sales-shift-value">$0.00</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Ventas por Día</h6>
                        <h4 class="fw-bold text-primary" id="sales-day-value">$0.00</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Ventas por Semana</h6>
                        <h4 class="fw-bold text-primary" id="sales-week-value">$0.00</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Ventas por Mes</h6>
                        <h4 class="fw-bold text-primary" id="sales-month-value">$0.00</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted mb-3">Ventas Diarias</h6>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/sales-analysis.js') }}" type="module"></script>
@endpush