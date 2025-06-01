@extends('layouts.main')

@section('title', 'Ventas')

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-10">
                <div class="card text-center shadow">
                    <div class="card-header">
                        <h3>{{ __('Detalles de la venta') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation p-2 p-md-3" novalidate>
                            <div id="divSalePatient">
                                <x-inputs.patient />
                            </div>
                            <div id="divSaleDetail">
                                <x-inputs.product-row />
                            </div>
                            <!-- Template oculto para clonar filas de producto desde JS -->
                            <div id="product-row-template" class="d-none">
                                <x-inputs.product-row />
                            </div>
                            <div id="divSaleFooter" class="mt-4">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-6 text-center text-sm-start mb-3 mb-sm-0">
                                        <h4>Total: <span id="totalSaleAmount">0.00</span></h4>
                                    </div>
                                    <div class="col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end gap-2">
                                        <input type="hidden" id="inputUserId" value="{{ Auth::user()->id }}">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto" id="saveSaleButton">Confirmar</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 w-sm-auto">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex flex-column flex-sm-row justify-content-between text-center text-sm-start">
                        <div>Cajero(a): {{ Auth::user()->name }}</div>
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
    <script src="{{ asset('js/sale.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sale.css') }}">
@endpush