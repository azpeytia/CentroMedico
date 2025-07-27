@extends('layouts.main')

@section('title', 'Consultas')

@section('content')
    <div class="container" id="consultations-create">
        <h3>{{ __('Crear Consulta') }}</h3>
        <form class="needs-validation" action="#" novalidate>
            <ul class="nav nav-tabs mb-3" id="consultationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Información Básica</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button" role="tab">Signos Vitales</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Historial</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="diagnosis-tab" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button" role="tab">Diagnóstico</button>
            </li>
        </ul>

        <div class="tab-content border p-4 bg-light rounded shadow-sm" id="consultationTabsContent">
            {{-- Tab 1: Información Básica --}}
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6" id="divConsultationDoctor">
                        <x-shared.doctor-input />
                    </div>
                    <div class="col-md-6" id="divConsultationPatient">
                        <x-shared.patient-input />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Razón de la consulta</label>
                        <textarea id="reason_for_consultation" class="form-control" name="reason_for_consultation" rows="2"></textarea>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Signos Vitales --}}
            <div class="tab-pane fade" id="vitals" role="tabpanel">
                <div class="row g-3">
                    @foreach([
                        'blood_pressure' => 'Presión arterial',
                        'heart_rate' => 'Latidos por minuto',
                        'respiratory_rate' => 'Respiraciones por minuto',
                        'oxygen_saturation' => 'Saturación de oxígeno',
                        'temperature' => 'Temperatura (°C)',
                        'weight' => 'Peso (kg)',
                        'height' => 'Altura (cm)'
                    ] as $name => $label)
                        <div class="col-md-4">
                            <label class="form-label">{{ $label }}</label>
                            <input type="text" class="form-control" name="{{ $name }}">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab 3: Historial Médico y Familiar --}}
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label">Alergias</label>
                    <textarea class="form-control" name="allergies" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Medicamentos actuales</label>
                    <textarea class="form-control" name="medications" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Condiciones médicas</label>
                    <textarea class="form-control" name="medical_conditions" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Historial médico</label>
                    <textarea class="form-control" name="medical_history" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Historial familiar</label>
                    <textarea class="form-control" name="family_history" rows="2"></textarea>
                </div>
            </div>

            {{-- Tab 4: Diagnóstico y Tratamiento --}}
            <div class="tab-pane fade" id="diagnosis" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label">Diagnóstico</label>
                    <textarea class="form-control" name="diagnosis" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tratamiento</label>
                    <textarea class="form-control" name="treatment" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Seguimiento</label>
                    <textarea class="form-control" name="follow_up_instructions" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" name="notes" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">Guardar Consulta</button>
        </div>
        </form>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/consultation.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush