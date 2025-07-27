<div class="row g-2 align-items-center">
    <div class="col-12">
        <label for="inputConsultationDoctor" class="form-label">Doctor</label>
        <input id="inputConsultationDoctor" type="text" class="inputConsultationDoctor form-control" name="inputConsultationDoctor" required>
        <div id="doctorSuggestions" class="doctor-suggestions mt-2">
            <!-- Aquí se mostrarán las sugerencias de doctores -->
        </div>
    </div>
    <div class="d-none">
        <input type="hidden" name="doctor_id" class="inputConsultationDoctorId" value="">
    </div>
</div>