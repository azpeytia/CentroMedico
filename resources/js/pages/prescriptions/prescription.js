document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('prescriptions-create')) {
        initializePage();
    }
});

function initializePage() {
    setInitialInputValues();
    setFocusInputPatient();
    searchPatient();
    searchProduct();
    initPrescriptionRowEvents();
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

function searchProduct() {
    // Delegación de eventos: escucha en el contenedor de productos
    const container = document.getElementById('products-container');
    container.addEventListener('input', async function(event) {
        const target = event.target;
        if (target && target.matches('input[name="inputPrescriptionProducts"]')) {
            event.preventDefault();
            const productName = target.value;

            if (productName.length >= 3) {
                try {
                    const eventResultDTO = await search_product_information(productName);

                    // Buscar el dropdown de sugerencias relativo a este input
                    const dropdown = target.closest('.flex-fill').querySelector('.product-suggestions');
                    updateProductSuggestions(eventResultDTO, dropdown, target);
                } catch (error) {
                    swalResponse(error);
                }
            } else {
                // Limpiar sugerencias si hay menos de 3 caracteres
                const dropdown = target.closest('.flex-fill').querySelector('.product-suggestions');
                if (dropdown) dropdown.innerHTML = '';
            }
        }
    });
}

function updateProductSuggestions(eventResultDTO, dropdown, inputElement) {
    if (!dropdown) return;
    dropdown.innerHTML = '';

    if (!eventResultDTO.result || !eventResultDTO.values.productRecords.length) {
        dropdown.innerHTML = '<div class="text-muted px-2 py-1">No se encontraron productos</div>';
        return;
    }

    // Obtener los nombres de productos ya seleccionados en todos los inputs excepto el actual
    const allInputs = Array.from(document.querySelectorAll('input[name="inputPrescriptionProducts"]'));
    const selectedNames = allInputs
        .filter(input => input !== inputElement && input.value.trim() !== '')
        .map(input => input.value.trim().toLowerCase());

    // Filtrar productos ya seleccionados
    const filteredProducts = eventResultDTO.values.productRecords.filter(product => {
        return !selectedNames.includes(product.name.trim().toLowerCase());
    });

    if (!filteredProducts.length) {
        dropdown.innerHTML = '<div class="text-muted px-2 py-1">No hay productos disponibles</div>';
        return;
    }

    const list = document.createElement('ul');
    list.className = 'list-group';

    filteredProducts.forEach(product => {
        const item = document.createElement('li');
        item.className = 'list-group-item list-group-item-action product-suggestion-item';
        item.textContent = product.name;
        item.dataset.productId = product.id;

        item.addEventListener('click', function() {
            inputElement.value = product.name;
            dropdown.innerHTML = '';
        });

        list.appendChild(item);
    });

    dropdown.appendChild(list);
}

function initPrescriptionRowEvents() {
    const container = document.getElementById('products-container');

    container.addEventListener('click', function (e) {
        const addBtn = e.target.closest('.prescription-add-product-button');
        const removeBtn = e.target.closest('.prescription-remove-product-button');

        if (addBtn) {
            const currentRow = addBtn.closest('.product-main-row');
            const inputs = currentRow.querySelectorAll('input[name="inputPrescriptionProducts"]');

            // Validar que todos los inputs en la fila actual tengan datos
            const allInputsFilled = Array.from(inputs).every(input => input.value.trim() !== '');

            if (!allInputsFilled) {
                swalResponse({
                    result: false,
                    message: 'Por favor, completa todos los campos de producto antes de agregar uno nuevo.'
                });
                return;
            }

            const clone = currentRow.cloneNode(true); // copia profunda

            // Limpia valores de todos los inputs del clon
            clone.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            // Habilita el botón "eliminar"
            const cloneRemoveBtn = clone.querySelector('.prescription-remove-product-button');
            if (cloneRemoveBtn) {
                cloneRemoveBtn.disabled = false;
            }

            container.appendChild(clone);
        }

        if (removeBtn) {
            const rows = container.querySelectorAll('.product-main-row');
            if (rows.length > 1) {
                const currentRow = removeBtn.closest('.product-main-row');
                currentRow.remove();
            }
        }
    });
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
console.log('Patient ID:', patientId);
        const products = Array.from(document.querySelectorAll('input[name="inputPrescriptionProducts"]'))
            .map(input => input.value.trim())
            .filter(value => value !== '');
console.log('Products:', products);
        if (products.length === 0) {
            swalResponse({ result: false, message: 'Debe agregar al menos un producto.' });
            return;
        }

        /* try {
            const response = await save_prescription(patientId, products);
            swalResponse(response);
            if (response.result) {
                // Redirigir o limpiar formulario si es necesario
                window.location.href = '/prescriptions';
            }
        } catch (error) {
            swalResponse(error);
        } */
    });
}