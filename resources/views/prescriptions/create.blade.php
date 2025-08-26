@extends('layouts.main')

@section('title', 'Prescripción')

@section('content')
    <div class="container" id="prescriptions-create">
        <h3>{{ __('Receta Médica') }}</h3>
        <form id="prescriptionForm" action="#">
            <div>
                <x-shared.patient-input />
            </div>
            <br>
            <div>
                <label>{{ __('Medicamentos') }}</label>
                <table class="table" id="products-table">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Cantidad</th>
                            <th>Instrucciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" name="products[0][name]" class="form-control product-name-input" list="products-list" autocomplete="off" required placeholder="Nombre del medicamento">
                                <datalist id="products-list">
                                    @foreach($products as $product)
                                        <option value="{{ $product->name }}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" name="products[0][quantity]" class="form-control" min="1" required>
                            </td>
                            <td>
                                <input type="text" name="products[0][instructions]" class="form-control" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-remove-row" style="display:none;">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" id="add-product-row">Agregar medicamento</button>
            </div>
            <br>
            <div>
                <label>{{ __('Notas Médicas') }}</label>
                <textarea
                    class="form-control"
                    name="medical_notes"
                    rows="4"
                    placeholder="Ingrese notas médicas aquí..."
                ></textarea>
            </div>
            <div class="mt-4 text-end">
                <x-shared.save-button id="saveButton">
                    Salvar
                </x-shared.save-button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
    window.products = @json($products);
</script>

@push('scripts')
    <script src="{{ asset('js/prescription.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/prescription.css') }}">
@endpush