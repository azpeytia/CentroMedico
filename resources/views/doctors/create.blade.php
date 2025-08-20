@extends('layouts.main')

@section('title', 'Doctores')

@section('content')
    <div class="container py-1" id="doctors-create">
        <h3 class="doctor-header">
            <i class="bi bi-journal-medical me-2" style="font-size:2rem;"></i>
            <span>{{ __('Agregar Doctor') }}</span>
        </h3>
        <div class="card shadow-sm p-4 mb-5 animate__animated animate__fadeIn">
            <form class="needs-validation" action="#" novalidate autocomplete="off">
                <div class="row g-2">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="inputDoctorName" class="form-label">
                            <i class="bi bi-person-badge me-1 text-primary"></i> Nombre
                        </label>
                        <input type="text" class="form-control" id="inputDoctorName" name="doctor_name" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="inputLicenseNumber" class="form-label">
                            <i class="bi bi-card-list me-1 text-primary"></i> Licencia Profesional
                        </label>
                        <input type="text" class="form-control" id="inputLicenseNumber" name="doctor_license_number" required placeholder="Ej: 12345678">
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="inputSpecialty" class="form-label">
                            <i class="bi bi-award me-1 text-primary"></i> Especialidad
                        </label>
                        <input type="text" class="form-control" id="inputSpecialty" name="doctor_specialty" required placeholder="Ej: Cardiología">
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="inputPhone" class="form-label">
                            <i class="bi bi-telephone me-1 text-primary"></i> Teléfono
                        </label>
                        <input type="tel" class="form-control" id="inputPhone" name="doctor_phone" required placeholder="Ej: 555-123-4567">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="inputEmail" class="form-label">
                            <i class="bi bi-envelope-at me-1 text-primary"></i> Correo Electrónico
                        </label>
                        <input type="email" class="form-control" id="inputEmail" name="doctor_email" required placeholder="Ej: doctor@email.com">
                    </div>
                </div>

                <div class="mt-4 d-flex flex-column flex-md-row gap-2 justify-content-end align-items-stretch align-items-md-center">
                    <x-shared.save-button class="w-100 w-md-auto">
                        Salvar
                    </x-shared.save-button>
                    <a href="{{ route('dashboard') }}" class="btn btn-cancel w-100 w-md-auto">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    window.dashboardUrl = "{{ route('dashboard') }}";
</script>

@push('scripts')
    <script src="{{ asset('js/doctor.js') }}" type="module"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
@endpush