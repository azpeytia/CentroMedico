@extends('layouts.main')

@section('title', 'Ventas')

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-10">
                <div class="card text-center shadow">
                    <div class="card-header">
                        <h3>Detalles de la venta</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation p-2 p-md-3" novalidate>
                            <div id="divReceiptSalePatient">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12">
                                        <input type="text" class="inputReceiptSalePatient form-control" placeholder="Paciente" required>
                                        <div id="patientSuggestions" class="patient-suggestions mt-2">
                                            <!-- Aquí se mostrarán las sugerencias de pacientes -->
                                        </div>
                                    </div>
                                    <div class="d-none">
                                        <input type="hidden" name="patient_id" class="inputReceiptSalePatientId" value="">
                                    </div>
                                </div>
                            </div>
                            <div id="divReceiptSaleDetail" class="mt-3">
                                <div class="row product-row g-2 align-items-stretch">
                                    <div class="col-12 col-sm-6 col-md-5">
                                        <input type="text" class="inputReceiptSaleProduct form-control" placeholder="Producto">
                                        <div class="product-suggestions mt-1">
                                            <!-- Aquí se mostrarán las sugerencias -->
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <input type="text" class="inputReceiptSaleQuantity form-control" placeholder="Cantidad">
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <input type="text" class="inputReceiptSaleProductPrice form-control" placeholder="Precio" readonly>
                                    </div>
                                    <div class="col-12 col-sm-3 col-md-2">
                                        <input type="text" class="inputReceiptSaleSubtotal form-control" placeholder="Subtotal" readonly>
                                    </div>
                                    <div class="d-none">
                                        <input type="hidden" name="product_id" class="inputReceiptSaleProductId" value="">
                                    </div>
                                    <div class="d-none">
                                        <input type="hidden" name="minimun_stock" class="inputReceiptSaleMinimunStock" value="">
                                    </div>
                                    <div class="col-12 col-sm-2 col-md-1 d-flex gap-1">
                                        <button type="button" class="btn btn-primary add-product-button" aria-label="Agregar producto">+</button>
                                        <button type="button" class="btn btn-danger remove-product-button" aria-label="Eliminar producto" disabled>&times;</button>
                                    </div>
                                </div>
                            </div>
                            <div id="divReceiptSaleFooter" class="mt-4">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-6 text-center text-sm-start mb-3 mb-sm-0">
                                        <h4>Total: <span id="totalSaleAmount">0.00</span></h4>
                                    </div>
                                    <div class="col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end gap-2">
                                        <input type="hidden" id="inputUserId" value="{{ Auth::user()->id }}">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto" id="saveReceiptSaleButton">Confirmar</button>
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