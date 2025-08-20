import { save_prescription_data } from "../../services/prescriptionService";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('prescriptions-create')) {
        initializePage();
    }
});

function initializePage() {
    setInitialInputValues();
    setFocusInputPatient();
    searchPatient();
    savePrescription();
}

function setInitialInputValues() {
    document.getElementById('inputPatient').value = '';
    document.getElementById('inputPatient').placeholder = 'Buscar paciente...';
    document.getElementById('inputPatientId').value = '';
}

function setFocusInputPatient() {
    document.getElementById('inputPatient').focus();
}

function searchPatient() {
    document.getElementById('inputPatient').addEventListener('input', async function(event) {
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
        dropdown.innerHTML = '<div class="text-muted px-2 py-1">No se encontraron pacientes</div>';
        return;
    }

    const list = document.createElement('ul');
    list.className = 'list-group';

    eventResultDTO.values.patientRecords.forEach(patient => {
        const item = document.createElement('li');
        item.className = 'list-group-item list-group-item-action patient-suggestion-item';
        item.textContent = patient.name;
        item.dataset.patientId = patient.id;

        item.addEventListener('click', function() {
            document.getElementById('inputPatient').value = patient.name;
            document.getElementById('inputPatientId').value = patient.id;
            dropdown.innerHTML = '';
        });

        list.appendChild(item);
    });

    dropdown.appendChild(list);
}

function savePrescription(){
    const saveButton = document.getElementById('saveButton');

    if (!saveButton) return;

    saveButton.addEventListener('click', async function(event) {
        event.preventDefault();

        const patientId = document.getElementById('inputPatientId').value.trim();
        if (!patientId) {
            swalResponse({ result: false, message: 'Debe seleccionar un paciente.' });
            return;
        }

        const medicalNotes = document.querySelector('textarea[name="medical_notes"]').value.trim();
        if (!medicalNotes) {
            swalResponse({ result: false, message: 'Debe ingresar notas médicas.' });
            return;
        }

        const mysqlDateValue = document.getElementById('mysql_date');
        const prescriptionData = {
            doctor_id: 1,
            patient_id: patientId,
            consultation_id: 1,
            notes: medicalNotes,
            prescription_date: mysqlDateValue.value,
        };

        try {
            const eventResultDTO = await save_prescription_data(prescriptionData);
            console.log(eventResultDTO);
            if (eventResultDTO.result) {
                swalResponse(eventResultDTO);
                redirectToHome();
            } else {
                swalResponse(eventResultDTO);
            }
        } catch (error) {
            swalResponse(error);
        }
    });
}

function redirectToHome() {
    window.location.href = window.dashboardUrl;
}