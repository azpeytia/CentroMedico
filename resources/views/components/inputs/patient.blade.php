<div class="row g-2 align-items-center">
    <div class="col-12">
        <!-- <label for="inputSalePatient" class="form-label">Paciente</label> -->
        <input id="inputSalePatient" type="text" class="inputSalePatient form-control" placeholder="Paciente" required>
        <div id="patientSuggestions" class="patient-suggestions mt-2">
            <!-- Aquí se mostrarán las sugerencias de pacientes -->
        </div>
    </div>
    <div class="d-none">
        <input type="hidden" name="patient_id" class="inputSalePatientId" value="">
    </div>
</div>