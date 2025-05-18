@extends('layouts.main')

@section('title', 'Inventarios')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1 class="display-4">{{ __('Turnos de inventarios') }}</h1>
                <p class="lead">{{ __('Seleccione iniciar o finalizar un turno de inventarios') }}</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 mb-3">
                <form id="startShiftForm">
                    <x-shift-button id="btnStartShift" type="success" :disabled="true">
                        {{ __('Iniciar Turno') }}
                    </x-shift-button>
                </form>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('Información del turno') }}
                    </div>
                    <div class="card-body text-center">
                        <p id="shift">-----</p>
                        <p id="date">{{ __('Fecha') }}: --/--/----</p>
                        <p id="hour">{{ __('Hora') }}: --:--:--</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <form id="endShiftForm">
                    <x-shift-button id="btnEndShift" type="danger" :disabled="true">
                        {{ __('Terminar Turno') }}
                    </x-shift-button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 text-center mt-1">
                <form id="inventoryRequestForm">
                    <x-shift-button id="btnInventoryRequest" type="info" :disabled="true">
                        {{ __('Requisición') }}
                    </x-shift-button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/shift-management.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shift.css') }}">
@endpush