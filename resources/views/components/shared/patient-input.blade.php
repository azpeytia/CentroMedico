<div class="row g-2 align-items-center">
    <div class="col-12">
        <label for="inputConsultationPatient" class="form-label">Paciente</label>
        <input id="inputConsultationPatient" type="text" class="inputConsultationPatient form-control" name="inputConsultationPatient" required>
        <div id="patientSuggestions" class="patient-suggestions mt-2">
            <!-- Aquí se mostrarán las sugerencias de pacientes -->
        </div>
    </div>
    <div class="d-none">
        <input type="hidden" name="patient_id" class="inputConsultationPatientId" value="">
    </div>
</div>