import { save_doctor_data } from "../../services/doctorService";

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('doctors-create')) {
        initializePage();
        initializeValidation();
    }
});

function initializePage() {
    setInitialInputValues();
    setFocusInputDoctorName();
}

function setInitialInputValues() {
    const fields = [
        { id: 'inputDoctorName', placeholder: 'Nombre del Doctor' },
        { id: 'inputLicenseNumber', placeholder: 'Licencia Profesional' },
        { id: 'inputSpecialty', placeholder: 'Especialidad' },
        { id: 'inputPhone', placeholder: 'Teléfono' },
        { id: 'inputEmail', placeholder: 'Correo Electrónico' }
    ];
    fields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input) {
            input.value = '';
            input.placeholder = field.placeholder;
        }
    });
}

function setFocusInputDoctorName() {
    document.getElementById('inputDoctorName').focus();
}

function initializeValidation() {
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', async function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Recolección de datos
        const formData = new FormData(form);
        const doctorData = {
            doctor_name: formData.get('doctor_name'),
            doctor_license_number: formData.get('doctor_license_number'),
            doctor_specialty: formData.get('doctor_specialty'),
            doctor_phone: formData.get('doctor_phone'),
            doctor_email: formData.get('doctor_email'),
        };

        // Enviar los datos al servidor
        try {
            const eventResultDTO = await save_doctor_data(doctorData);

            if (eventResultDTO.result) {
                swalResponse(eventResultDTO);
                redirectToHome();
            } else {
                swalResponse(eventResultDTO);
            }
        } catch (error) {
            swalResponse(error);
        }
        form.classList.add('was-validated');
    });
}

function redirectToHome() {
    window.location.href = window.dashboardUrl;
}