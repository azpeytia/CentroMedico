@extends('layouts.main')

@section('title', 'Consultas')

@section('content')
    <div class="container py-1" id="consultations-create">
        <h3 class="consultation-header">
            <i class="bi bi-journal-medical me-2"></i>
            {{ __('Crear Consulta') }}
        </h3>
        <form class="needs-validation" action="#" novalidate>
            {{-- Navegación por Tabs --}}
            <ul class="nav nav-tabs mb-1" id="consultationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                        <i class="bi bi-person-vcard me-1"></i>
                        Información Básica
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button" role="tab">
                        <i class="bi bi-heart-pulse me-1"></i>
                        Signos Vitales
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                        <i class="bi bi-clock-history me-1"></i>
                        Historial
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="diagnosis-tab" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button" role="tab">
                        <i class="bi bi-clipboard2-pulse me-1"></i>
                        Diagnóstico
                    </button>
                </li>
            </ul>

            <div class="tab-content border px-4 pt-2 pb-4 bg-light rounded shadow-sm" id="consultationTabsContent">
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
                            <label class="form-label fw-semibold">Razón de la consulta</label>
                            <textarea id="reason_for_consultation" class="form-control" name="reason_for_consultation" rows="2" placeholder="Describa brevemente el motivo de la consulta..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Signos Vitales --}}
                <div class="tab-pane fade" id="vitals" role="tabpanel">
                    <div class="row g-3">
                        @foreach([
                            'blood_pressure' => ['Presión arterial', 'mmHg'],
                            'heart_rate' => ['Latidos por minuto', 'lpm'],
                            'respiratory_rate' => ['Respiraciones por minuto', 'rpm'],
                            'oxygen_saturation' => ['Saturación de oxígeno', '%'],
                            'temperature' => ['Temperatura', '°C'],
                            'weight' => ['Peso', 'kg'],
                            'height' => ['Altura', 'cm'],
                        ] as $name => [$label, $unit])
                            <div class="col-md-4">
                                <x-shared.input 
                                    type="number" 
                                    :name="$name" 
                                    :label="$label" 
                                    :placeholder="$label" 
                                    step="any" 
                                    :unit="$unit" 
                                />
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tab 3: Historial Médico y Familiar --}}
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <div class="row g-3">
                        @foreach([
                            'allergies' => 'Alergias',
                            'medications' => 'Medicamentos actuales',
                            'medical_conditions' => 'Condiciones médicas',
                            'medical_history' => 'Historial médico',
                            'family_history' => 'Historial familiar',
                        ] as $name => $label)
                            <div class="col-12">
                                <x-shared.textarea 
                                    :name="$name" 
                                    :label="$label" 
                                    rows="2" 
                                    :placeholder="'Ingrese información sobre ' . strtolower($label) . '...'"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tab 4: Diagnóstico y Tratamiento --}}
                <div class="tab-pane fade" id="diagnosis" role="tabpanel">
                    <div class="row g-3">
                        @foreach([
                            'diagnosis' => 'Diagnóstico',
                            'treatment' => 'Tratamiento',
                            'follow_up_instructions' => 'Instrucciones de seguimiento',
                            'notes' => 'Notas adicionales',
                        ] as $name => $label)
                            <div class="col-12">
                                <x-shared.textarea 
                                    :name="$name" 
                                    :label="$label" 
                                    :rows="$name === 'notes' ? 3 : 2" 
                                    :placeholder="'Ingrese ' . strtolower($label) . '...'"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
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
    <script src="{{ asset('js/consultation.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush