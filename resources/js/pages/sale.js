$(document).ready(function() {
    $('#divSalePatient .inputSalePatient').focus();
    initializePage();
});

const SELECTORS = {
    productRow: '.product-row',
    inputSaleProduct: '.inputSaleProduct',
    inputSaleProductId: '.inputSaleProductId',
    inputSaleProductPrice: '.inputSaleProductPrice',
    inputSaleMinimunStock: '.inputSaleMinimunStock',
    inputSaleQuantity: '.inputSaleQuantity',
    inputSaleSubtotal: '.inputSaleSubtotal',
    addProductButton: '.add-product-button',
    removeProductButton: '.remove-product-button',
    productSuggestions: '.product-suggestions',
    suggestionItem: '.suggestion-item',
    divSaleDetail: '#divSaleDetail',
    productRowTemplate: '#product-row-template',
    inputSalePatient: '.inputSalePatient',
    inputSalePatientId: '.inputSalePatientId',
    patientSuggestions: '#patientSuggestions',
    saveSaleButton: '#saveSaleButton',
    totalSaleAmount: '#totalSaleAmount',
    shiftId: '#shift_id',
    mysqlDate: '#mysql_date',
    hour: '#hour',
    inputUserId: '#inputUserId',
};

const ERROR_MESSAGES = {
    fillAllFields: 'Debe completar todos los campos',
    duplicateProduct: 'El producto ya fue agregado',
    selectPatient: 'Debe seleccionar un paciente.',
    addProduct: 'Debe agregar al menos un producto.',
    totalGreaterThanZero: 'El total de la venta debe ser mayor a cero.',
    quantityGreaterThanZero: 'La cantidad de cada producto debe ser mayor a cero.',
    priceGreaterThanZero: 'El precio de cada producto debe ser mayor a cero.',
    stockExceeded: 'La cantidad solicitada excede el stock disponible',
    stockZero: 'El stock ha llegado a cero',
    stockMinimum: 'Se alcanzó el stock mínimo',
};

async function initializePage() {
    await loadShiftInformation();
    await loadInventoryInformation();
    searchPatientName();
    handleProductRows();
    searchProductName();
    saveReceiptSale();

    $(document).on('keyup', SELECTORS.inputSaleQuantity, function() {
        let row = $(this).closest(SELECTORS.productRow);

        checkProductStock(row);
        calculateSubtotal(row);
        calculateTotal();
    });

    $(document).on('click', SELECTORS.addProductButton + ', ' + SELECTORS.removeProductButton, function() {
        calculateTotal();
    });
}

async function loadShiftInformation() {
    const eventRecord = $(SELECTORS.hour).text();

    try {
        const eventResultDTO = await get_shift_information(eventRecord);

        if (eventResultDTO.result) {
            const shiftId = eventResultDTO.values.shiftRecords.id;
            $(SELECTORS.shiftId).val(shiftId);
        } else {
            swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

async function loadInventoryInformation() {
    const mysqlDateValue = $(SELECTORS.mysqlDate).val();
    const shiftDate = mysqlDateValue.split(' ')[0];
    const shiftId = $(SELECTORS.shiftId).val();
    const eventRecord = {
        shiftDate: shiftDate,
        shiftId: shiftId
    }

    try {
        const eventResultDTO = await get_inventory_information(eventRecord);

        if (eventResultDTO.result) {
        } else {
            swalResponse(eventResultDTO);

            redirectToHome();
        }
    } catch (error) {
        swalResponse(error);
    }
}

function searchPatientName() {
    $(document).on('keyup', SELECTORS.inputSalePatient, async function(event) {
        event.preventDefault();

        let eventRecord = $(this).val();

        try {
            const eventResultDTO = await search_patient_information(eventRecord);

            if (eventResultDTO.result && eventResultDTO.values.patientRecords.length > 0) {
                updatePatientSuggestions(eventResultDTO);
            } else {
                $(SELECTORS.patientSuggestions).empty();
            }
        } catch (error) {
            swalResponse(error);
        }
    });
}

function updatePatientSuggestions(eventResultDTO) {
    const dropdown = $(SELECTORS.patientSuggestions);
    dropdown.empty();

    eventResultDTO.values.patientRecords.forEach(patient => {
        dropdown.append(`
            <div class="suggestion-item" data-id="${patient.id}">
                ${patient.name}
            </div>
        `);
    });

    dropdown.show();

    $(SELECTORS.suggestionItem).on('click', function() {
        const selectedPatientId = $(this).data('id');
        const selectedPatientName = $(this).text().trim();

        $(SELECTORS.inputSalePatient).val(selectedPatientName);
        $(SELECTORS.inputSalePatientId).val(selectedPatientId);

        dropdown.empty();
        dropdown.hide();

        $('#divSaleDetail').find('.inputSaleProduct:visible:first').focus();
    });
}

function handleProductRows() {
    $(document).on('click', SELECTORS.addProductButton, function() {
        let currentRow = $(this).closest(SELECTORS.productRow);

        // Valida si todos los campos están completos
        if (!validateProductRow(currentRow)) {
            swalResponse({ result: false, message: ERROR_MESSAGES.fillAllFields });
            return;
        }

        // Verifica si productos duplicados
        let currentProductName = currentRow.find(SELECTORS.inputSaleProduct).val();
        if (isDuplicateProduct(currentProductName, currentRow)) {
            swalResponse({ result: false, message: ERROR_MESSAGES.duplicateProduct });
            return;
        }

        addNewProductRow();
    });

    $(document).on('click', SELECTORS.removeProductButton, function() {
        $(this).closest(SELECTORS.productRow).remove();
        calculateTotal();
    });
}

function validateProductRow(row) {
    let allInputsFilled = true;
    let quantity = parseInt(row.find(SELECTORS.inputSaleQuantity).val()) || 0;
    let price = parseFloat(row.find(SELECTORS.inputSaleProductPrice).val()) || 0;

    row.find('input').each(function() {
        if (!$(this).val()) {
            allInputsFilled = false;
        }
    });

    if (!allInputsFilled) return false;
    if (quantity <= 0) return false;
    if (price <= 0) return false;

    return true;
}

function isDuplicateProduct(productName, currentRow) {
    let isDuplicate = false;
    $(SELECTORS.productRow).not(currentRow).each(function() {
        let existingProductName = $(this).find(SELECTORS.inputSaleProduct).val();
        if (productName === existingProductName) {
            isDuplicate = true;
        }
    });
    return isDuplicate;
}

function addNewProductRow() {
    let productRow = $(SELECTORS.productRowTemplate).html();
    $(SELECTORS.divSaleDetail).append(productRow);

    $(SELECTORS.divSaleDetail).find(SELECTORS.productRow).last().find(SELECTORS.inputSaleProduct).focus();
}

function searchProductName() {
    $(document).on('keyup', SELECTORS.inputSaleProduct, async function(event) {
        event.preventDefault();

        let productRow = $(this).closest(SELECTORS.productRow);
        let eventRecord = productRow.find(SELECTORS.inputSaleProduct).val();

        try {
            let eventResultDTO = await search_product_information(eventRecord);

            if (eventResultDTO.result && eventResultDTO.values.productRecords.length > 0) {
                let dropdown = productRow.find(SELECTORS.productSuggestions);
                dropdown.empty();

                eventResultDTO.values.productRecords.forEach(product => {
                    dropdown.append(`
                        <div class="suggestion-item" data-id="${product.id}" data-price="${product.price}" data-stock="${product.stock}" data-minimum="${product.min_stock}">
                            ${product.name}
                        </div>
                    `);
                });

                dropdown.show();
            } else {
                productRow.find(SELECTORS.inputSaleProductId).val('');
                productRow.find(SELECTORS.productSuggestions).hide();
            }
        } catch (error) {
            productRow.find(SELECTORS.productSuggestions).hide();
            swalResponse(error);
        }
    });

    $(document).on('click', SELECTORS.suggestionItem, function() {
        let productRow = $(this).closest(SELECTORS.productRow);
        let selectedProductId = $(this).data('id');
        let selectedProductName = $(this).text().trim();
        let selectedProductPrice = $(this).data('price');
        let selectedProductStock = $(this).data('stock');
        let selectedProductMinimunStock = $(this).data('minimum');

        productRow.find(SELECTORS.inputSaleProduct).val(selectedProductName);
        productRow.find(SELECTORS.inputSaleProductId).val(selectedProductId);
        productRow.find(SELECTORS.inputSaleProductPrice).val(selectedProductPrice);
        productRow.find(SELECTORS.inputSaleMinimunStock).val(selectedProductMinimunStock);
        productRow.data('stock', selectedProductStock);
        productRow.find(SELECTORS.productSuggestions).empty().hide();
        productRow.find(SELECTORS.inputSaleQuantity).focus();
    });
}

function checkProductStock(row) {
    let quantity = parseInt(row.find(SELECTORS.inputSaleQuantity).val()) || 0;
    let stock = parseInt(row.data('stock')) || 0;

    if (quantity > stock) {
        swalResponse({ result: false, message: ERROR_MESSAGES.stockExceeded });
        row.find(SELECTORS.inputSaleQuantity).val(stock);
    } else {
        checkMinimumStock(row);
    }
}

function checkMinimumStock(row) {
    let stock = parseInt(row.data('stock')) || 0;
    let quantity = parseInt(row.find(SELECTORS.inputSaleQuantity).val()) || 0;
    let futureStock = stock - quantity;
    let minimumStock = parseInt(row.find(SELECTORS.inputSaleMinimunStock).val()) || 0;

    if (futureStock === 0) {
        swalResponse({ result: true, message: ERROR_MESSAGES.stockZero });
    } else if (futureStock <= minimumStock) {
        swalResponse({ result: true, message: ERROR_MESSAGES.stockMinimum });
        row.find(SELECTORS.inputSaleQuantity).val(minimumStock);
    }
}

function calculateSubtotal(row) {
    let quantity = parseInt(row.find(SELECTORS.inputSaleQuantity).val()) || 0;
    let price = parseFloat(row.find(SELECTORS.inputSaleProductPrice).val()) || 0;
    let subtotal = quantity * price;

    row.find(SELECTORS.inputSaleSubtotal).val(subtotal.toFixed(2));
    return subtotal;
}

function calculateTotal() {
    let total = 0;

    $(SELECTORS.productRow).each(function(index, element) {
        total += calculateSubtotal($(element));
    });

    $(SELECTORS.totalSaleAmount).text(total.toFixed(2));
}

function saveReceiptSale() {
    $(SELECTORS.saveSaleButton).on('click', async function(event) {
        event.preventDefault();

        const eventRecord = getSaleData();
        const saleProductData = getSaleProductData();

        if (!eventRecord.patient_id) {
            swalResponse({ result: false, message: ERROR_MESSAGES.selectPatient });
            return;
        }

        if (!saleProductData.products.length) {
            swalResponse({ result: false, message: ERROR_MESSAGES.addProduct });
            return;
        }

        if (eventRecord.total <= 0) {
            swalResponse({ result: false, message: ERROR_MESSAGES.totalGreaterThanZero });
            return;
        }

        for (const product of saleProductData.products) {
            if (product.quantity <= 0) {
                swalResponse({ result: false, message: ERROR_MESSAGES.quantityGreaterThanZero });
                return;
            }
            if (product.unit_price <= 0) {
                swalResponse({ result: false, message: ERROR_MESSAGES.priceGreaterThanZero });
                return;
            }
        }

        //Unir los datos de la venta y los productos
        const payload = {
            ...eventRecord,
            ...saleProductData,
        };

        // Enviar los datos al servidor
        try {
            const eventResultDTO = await save_sale_information(payload);

            handleServerResponse(eventResultDTO);
        } catch (error) {
            swalResponse(error);
        }
    });
}

function getSaleData() {
    // Construir el objeto de datos de la venta
    return {
        patient_id: parseInt($(SELECTORS.inputSalePatientId).val()) || 0,
        shift_id: parseInt($(SELECTORS.shiftId).val()) || 0,
        user_id: parseInt($(SELECTORS.inputUserId).val()) || 0,
        total: parseFloat($(SELECTORS.totalSaleAmount).text()) || 0,
        status: 'Pendiente',
        payment_method: 'Efectivo',
        is_active: 1,
        is_suspended: 0,
        is_deleted: 0,
    };
}

function getSaleProductData() {
    // Captura todos los productos y cantidades de la venta
    const products = [];

    $(SELECTORS.productRow).each(function() {
        const productId = parseInt($(this).find(SELECTORS.inputSaleProductId).val()) || 0;
        const quantity = parseInt($(this).find(SELECTORS.inputSaleQuantity).val()) || 0;
        const unit_price = parseFloat($(this).find(SELECTORS.inputSaleProductPrice).val()) || 0;
        const subtotal = quantity * unit_price;

        if (productId > 0 && quantity > 0 && unit_price > 0) {
            products.push({
                product_id: productId,
                quantity: quantity,
                unit_price: unit_price,
                subtotal: subtotal,
                is_active: 1,
            });
        }
    });

    // Construir el objeto de datos de los productos de la venta
    return {
        products: products,
    };
}

function handleServerResponse(eventResultDTO) {
    if (eventResultDTO.result) {
        swalResponse(eventResultDTO);

        redirectToHome();
    } else {
        swalResponse(eventResultDTO);
    }
}

function redirectToHome() {
    setTimeout(() => {
        window.location.href = window.dashboardUrl;
    }, 3000);
}