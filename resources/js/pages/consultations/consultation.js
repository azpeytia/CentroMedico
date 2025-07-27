document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('consultations-create')) {
        initializePage();
        initializeValidation();
        initializeTabs();
    }
});

function initializePage() {
    setInitialInputValues();
    setFocusInputDoctor();
    searchDoctor();
    searchPatient();
}

function initializeValidation() {
    const form = document.querySelector('.needs-validation');
    if (!form) return;
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Recolectar todos los datos del formulario
        const formData = new FormData(form);

        const mysqlDateValue = document.getElementById('mysql_date');
        const consultation_date = mysqlDateValue.value;
        const is_active = 1;
        const is_suspended = 0;
        const is_deleted = 0;
        const nameMap = {
            'inputConsultationDoctor': 'doctorName',
            'doctor_id': 'doctor_id',
            'inputConsultationPatient': 'patientName',
            'patient_id': 'patient_id',
            'consultation_date': 'consultation_date',
            'reason_for_consultation': 'reason_for_consultation',
            'allergies': 'allergies',
            'blood_pressure': 'blood_pressure',
            'heart_rate': 'heart_rate',
            'respiratory_rate': 'respiratory_rate',
            'oxygen_saturation': 'oxygen_saturation',
            'temperature': 'temperature',
            'weight': 'weight',
            'height': 'height',
            'medications': 'medications',
            'medical_conditions': 'medical_conditions',
            'medical_history': 'medical_history',
            'family_history': 'family_history',
            'diagnosis': 'diagnosis',
            'treatment': 'treatment',
            'follow_up_instructions': 'follow_up_instructions',
            'notes': 'notes',
            'is_active': 'is_active',
            'is_suspended': 'is_suspended',
            'is_deleted': 'is_deleted',
        };

        const consultationData = {};
        /* formData.forEach((value, key) => {
            consultationData[nameMap[key]] = value;
        }); */
        /* for (const [key, value] of formData.entries()) {
            if (nameMap[key]) {
                consultationData[nameMap[key]] = value;
            }
        } */
       for (const [formKey, mappedKey] of Object.entries(nameMap)) {
            if (formData.has(formKey)) {
                consultationData[mappedKey] = formData.get(formKey);
            } else if (formKey === 'consultation_date') {
                consultationData[mappedKey] = consultation_date;
            } else if (formKey === 'is_active') {
                consultationData[mappedKey] = is_active;
            } else if (formKey === 'is_suspended') {
                consultationData[mappedKey] = is_suspended;
            } else if (formKey === 'is_deleted') {
                consultationData[mappedKey] = is_deleted;
            } else {
                consultationData[mappedKey] = null; // Asignar valor vacío si no existe en formData
            }
        }
        console.log(consultationData);
        try {
            const eventResultDTO = await save_consultation_information(consultationData);
            console.log(eventResultDTO);
            showSuccessToast('Consulta guardada con éxito');
            form.reset();
            form.classList.remove('was-validated');
            setInitialInputValues();
            setFocusInputDoctor();
            // Redirigir o limpiar formulario si es necesario
        } catch (error) {
            swalResponse(error);
        }
        form.classList.add('was-validated');
    });
}

function initializeTabs() {
    // Inicializar la pestaña activa
    const activeTab = document.querySelector('#consultationTabs .nav-link.active');
    if (activeTab) {
        const tabs = new bootstrap.Tab(activeTab);
        tabs.show();
    }

    // Pestaña activa persistente con localStorage
    const storedTab = localStorage.getItem('activeTab');
    if (storedTab) {
        const trigger = document.querySelector(`button[data-bs-target="${storedTab}"]`);
        if (trigger) new bootstrap.Tab(trigger).show();
    }

    const tabButtons = document.querySelectorAll('#consultationTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', e => {
            localStorage.setItem('activeTab', e.target.dataset.bsTarget);
        });
    });
}

function showSuccessToast(message) {
    const toastBody = document.getElementById('mainToastBody');
    if (toastBody) toastBody.textContent = message;
    const toastElement = document.getElementById('mainToast');
    if (toastElement) {
        const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
        toast.show();
    }
}

function setInitialInputValues() {
    document.getElementById('inputConsultationDoctor').value = '';
    document.getElementById('inputConsultationDoctor').placeholder = 'Buscar doctor...';
    document.querySelector('.inputConsultationDoctorId').value = '';
    document.getElementById('inputConsultationPatient').value = '';
    document.getElementById('inputConsultationPatient').placeholder = 'Buscar paciente...';
    document.querySelector('.inputConsultationPatientId').value = '';
    document.getElementById('reason_for_consultation').value = '';
    document.getElementById('reason_for_consultation').placeholder = 'Entrevista...';
}

function setFocusInputDoctor() {
    document.getElementById('inputConsultationDoctor').focus();
}

function searchDoctor() {
    document.getElementById('inputConsultationDoctor').addEventListener('input', async function(event) {
        event.preventDefault();
        const doctorName = this.value;

        if (doctorName.length >= 3) {
            try {
                const eventResultDTO = await search_doctor_information(doctorName);
                updateDoctorSuggestions(eventResultDTO);
            } catch (error) {
                swalResponse(error);
            }
        }
    });
}

function updateDoctorSuggestions(eventResultDTO) {
    const dropdown = document.getElementById('doctorSuggestions');
    dropdown.innerHTML = '';

    if (!eventResultDTO.result || !eventResultDTO.values.doctorRecords.length) {
        dropdown.innerHTML = '<div class="text-muted px-2 py-1">No se encontraron doctores.</div>';
        return;
    }

    const list = document.createElement('ul');
    list.className = 'list-group';

    eventResultDTO.values.doctorRecords.forEach(doctor => {
        const item = document.createElement('li');
        item.className = 'list-group-item list-group-item-action doctor-suggestion-item';
        item.textContent = doctor.name + (doctor.specialty ? ` (${doctor.specialty})` : '');
        item.dataset.doctorId = doctor.id;

        item.addEventListener('click', function() {
            document.getElementById('inputConsultationDoctor').value = doctor.name;
            document.querySelector('.inputConsultationDoctorId').value = doctor.id;
            dropdown.innerHTML = '';
        });

        list.appendChild(item);
    });

    dropdown.appendChild(list);
}

function searchPatient() {
    document.getElementById('inputConsultationPatient').addEventListener('input', async function(event) {
        event.preventDefault();
        const patientName = this.value;

        if (patientName.length >= 3) {
            try {
                const eventResultDTO = await search_patient_information(patientName);

                updatePatientSuggestions(eventResultDTO);
            } catch (error) {
                swalResponse(error);
            }
        }
    });
}

function updatePatientSuggestions(eventResultDTO) {
    const dropdown = document.getElementById('patientSuggestions');
    dropdown.innerHTML = '';

    if (!eventResultDTO.result || !eventResultDTO.values.patientRecords.length) {
        dropdown.innerHTML = '<div class="text-muted px-2 py-1">No se encontraron pacientes.</div>';
        return;
    }

    const list = document.createElement('ul');
    list.className = 'list-group';

    eventResultDTO.values.patientRecords.forEach(patient => {
        const item = document.createElement('li');
        item.className = 'list-group-item list-group-item-action patient-suggestion-item';
        item.textContent = patient.name + (patient.document ? ` (${patient.document})` : '');
        item.dataset.patientId = patient.id;

        item.addEventListener('click', function() {
            document.getElementById('inputConsultationPatient').value = patient.name;
            document.querySelector('.inputConsultationPatientId').value = patient.id;
            dropdown.innerHTML = '';
        });

        list.appendChild(item);
    });

    dropdown.appendChild(list);
}