import { save_prescription_data } from "../../services/prescriptionService";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('prescriptions-create')) {
        initializePage();
        setupProductRows();
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

function setupProductRows() {
    const addBtn = document.getElementById('add-product-row');
    const tableBody = document.querySelector('#products-table tbody');
    let rowIndex = 1;

    addBtn.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <input type="text" name="products[${rowIndex}][name]" class="form-control product-name-input" list="products-list" autocomplete="off" required placeholder="Nombre del medicamento">
            </td>
            <td>
                <input type="number" name="products[${rowIndex}][quantity]" class="form-control" min="1" required>
            </td>
            <td>
                <input type="text" name="products[${rowIndex}][instructions]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-remove-row">Eliminar</button>
            </td>
        `;
        tableBody.appendChild(newRow);
        rowIndex++;
        updateRemoveButtons();
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-row')) {
            e.target.closest('tr').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, idx) => {
            const btn = row.querySelector('.btn-remove-row');
            if (btn) btn.style.display = rows.length > 1 ? '' : 'none';
        });
    }
    updateRemoveButtons();
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

        // Obtener productos
        const productRows = document.querySelectorAll('#products-table tbody tr');
        const products = [];
        let valid = true;
        productRows.forEach(row => {
            const name = row.querySelector('input.product-name-input').value.trim();
            const quantity = row.querySelector('input[type="number"]').value;
            const instructions = row.querySelectorAll('input[type="text"]')[1].value;
            if (!name || !quantity || !instructions) valid = false;
            products.push({ name, quantity, instructions });
        });
        if (!valid || products.length === 0) {
            swalResponse({ result: false, message: 'Debe ingresar al menos un medicamento con todos los campos.' });
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

function redirectToHome() {
    window.location.href = window.dashboardUrl;
}