@extends('layouts.main')

@section('title', 'Prescripción')

@section('content')
    <div class="container" id="prescriptions-create">
        <h3>{{ __('Receta Médica') }}</h3>
        <form action="#">
            <div>
                <x-shared.patient-input />
            </div>
            <div id="products-container">
                <div class="product-main-row d-flex flex-column gap-2 mb-3">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <label for="inputPrescriptionProducts" class="form-label">Producto</label>
                            <input
                                id="inputPrescriptionProducts"
                                type="text"
                                class="form-control"
                                name="inputPrescriptionProducts"
                                placeholder="Buscar producto..."
                                autocomplete="off"
                            >
                            <div id="productSuggestions" class="product-suggestions mt-2">
                                <!-- Aquí se mostrarán las sugerencias de productos -->
                            </div>
                        </div>
                        <div id="quantity-row-template" class="flex-fill">
                            <label for="inputPrescriptionQuantity" class="form-label">Cantidad</label>
                            <input
                                id="inputPrescriptionQuantity"
                                type="number"
                                class="form-control"
                                name="inputPrescriptionQuantity"
                                placeholder="Ingrese la cantidad..."
                                min="1"
                            >
                        </div>
                        <div id="dosage-row-template" class="flex-fill">
                            <label for="inputPrescriptionDosage" class="form-label">Dosis</label>
                            <input
                                id="inputPrescriptionDosage"
                                type="text"
                                class="form-control"
                                name="inputPrescriptionDosage"
                                placeholder="Ingrese la dosis..."
                                autocomplete="off"
                            >
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-end">
                        <div id="frequency-row-template" class="flex-fill">
                            <label for="inputPrescriptionFrequency" class="form-label">Frecuencia</label>
                            <input
                                id="inputPrescriptionFrequency"
                                type="text"
                                class="form-control"
                                name="inputPrescriptionFrequency"
                                placeholder="Ingrese la frecuencia..."
                                autocomplete="off"
                            >
                        </div>
                        <div id="duration-row-template" class="flex-fill">
                            <label for="inputPrescriptionDuration" class="form-label">Duración</label>
                            <input
                                id="inputPrescriptionDuration"
                                type="text"
                                class="form-control"
                                name="inputPrescriptionDuration"
                                placeholder="Ingrese la duración..."
                                autocomplete="off"
                            >
                        </div>
                        <div id="instructions-row-template" class="flex-fill">
                            <label for="inputPrescriptionInstructions" class="form-label">Instrucciones</label>
                            <input
                                id="inputPrescriptionInstructions"
                                type="text"
                                class="form-control"
                                name="inputPrescriptionInstructions"
                                placeholder="Ingrese las instrucciones..."
                                autocomplete="off"
                            >
                        </div>
                        <div class="d-flex align-items-end">
                            <button type="button" class="btn btn-primary prescription-add-product-button" aria-label="Agregar producto">+</button>
                            <button type="button" class="btn btn-danger prescription-remove-product-button" aria-label="Eliminar producto" disabled>&times;</button>
                            <input type="hidden" name="product_id[]" class="inputPrescriptionProductId" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label>{{ __('Notas Adicionales') }}</label>
                <textarea
                    class="form-control"
                    name="additional_notes"
                    rows="3"
                    placeholder="Ingrese notas adicionales aquí..."
                >
                </textarea>
            </div><div class="mt-4 text-end">
                <x-shared.save-button>
                    Salvar
                </x-shared.save-button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/prescription.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/prescription.css') }}">
@endpush