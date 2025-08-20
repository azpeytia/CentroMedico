@extends('layouts.main')

@section('title', 'Prescripción')

@section('content')
    <div class="container" id="prescriptions-create">
        <h3>{{ __('Receta Médica') }}</h3>
        <form action="#">
            <div>
                <x-shared.patient-input />
            </div>
            <br>
            <div>
                <label>{{ __('Notas Médicas') }}</label>
                <textarea
                    class="form-control"
                    name="medical_notes"
                    rows="7"
                    placeholder="Ingrese notas médicas aquí..."
                ></textarea>
            </div>
            <div class="mt-4 text-end">
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