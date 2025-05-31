$(document).ready(function() {
    initializePage();
});

async function initializePage() {
    await loadShiftInformation();
    await loadInventoryInformation();
    searchPatientName();
    handleProductRows();
    searchProductName();
    saveReceiptSale();

    // Eventos para calcular subtotales y total general
    $(document).on('keyup', '.inputReceiptSaleQuantity', function() {
        let row = $(this).closest('.product-row');

        checkProductStock(row);
        calculateSubtotal(row);
        calculateTotal();
    });

    $(document).on('click', '.add-product-button, .remove-product-button', function() {
        calculateTotal();
    });
}

async function loadShiftInformation() {
    const eventRecord = $('#hour').text();

    try {
        const eventResultDTO = await get_shift_information(eventRecord);

        if (eventResultDTO.result) {
            const shiftId = eventResultDTO.values.shiftRecords.id;
            $('#shift_id').val(shiftId);
        } else {
            swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

async function loadInventoryInformation() {
    const mysqlDateValue = $('#mysql_date').val();
    const shiftDate = mysqlDateValue.split(' ')[0]; // Extrae solo "2025-03-26"
    const shiftId = $('#shift_id').val();
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
    $(document).on('keyup', '.inputReceiptSalePatient', async function(event) {
        event.preventDefault();

        let eventRecord = $(this).val();

        try {
            const eventResultDTO = await search_patient_information(eventRecord);

            if (eventResultDTO.result && eventResultDTO.values.patientRecords.length > 0) {
                updatePatientSuggestions(eventResultDTO);
            } else {
                $('#patientSuggestions').empty();
            }
        } catch (error) {
            swalResponse(error);
        }
    });
}

function updatePatientSuggestions(eventResultDTO) {
    const dropdown = $('#patientSuggestions');
    dropdown.empty();

    eventResultDTO.values.patientRecords.forEach(patient => {
        dropdown.append(`
            <div class="suggestion-item" data-id="${patient.id}">
                ${patient.name}
            </div>
        `);
    });

    dropdown.show();

    $('.suggestion-item').on('click', function() {
        const selectedPatientId = $(this).data('id');
        const selectedPatientName = $(this).text().trim();

        $('.inputReceiptSalePatient').val(selectedPatientName);
        $('.inputReceiptSalePatientId').val(selectedPatientId);

        dropdown.empty();
        dropdown.hide();
    });
}

function handleProductRows() {
    $(document).on('click', '.add-product-button', function() {
        let currentRow = $(this).closest('.product-row');

        // Valida si todos los campos están completos
        if (!validateProductRow(currentRow)) {
            const eventResultDTO = {
                result: false,
                message: 'Debe completar todos los campos',
            };
            swalResponse(eventResultDTO);
            return;
        }

        // Verifica si productos duplicados
        let currentProductName = currentRow.find('.inputReceiptSaleProduct').val();
        if (isDuplicateProduct(currentProductName, currentRow)) {
            const eventResultDTO = {
                result: false,
                message: 'El producto ya fue agregado',
            };
            swalResponse(eventResultDTO);
            return;
        }

        // Agrega una nueva fila de productos
        addNewProductRow();
    });

    $(document).on('click', '.remove-product-button', function() {
        $(this).closest('.product-row').remove();
        calculateTotal();
    });
}

function validateProductRow(row) {
    let allInputsFilled = true;
    row.find('input').each(function() {
        if (!$(this).val()) {
            allInputsFilled = false;
        }
    });
    return allInputsFilled;
}

function isDuplicateProduct(productName, currentRow) {
    let isDuplicate = false;
    $('.product-row').not(currentRow).each(function() {
        let existingProductName = $(this).find('.inputReceiptSaleProduct').val();
        if (productName === existingProductName) {
            isDuplicate = true;
        }
    });
    return isDuplicate;
}

function addNewProductRow() {
        let productRow = `
        <div class="row product-row g-2 align-items-end">
            <div class="col-12 col-sm-6 col-md-4">
                <input type="text" class="inputReceiptSaleProduct form-control" placeholder="Producto">
                <div class="product-suggestions mt-1">
                    <!-- Aquí se mostrarán las sugerencias -->
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <input type="text" class="inputReceiptSaleQuantity form-control" placeholder="Cantidad">
            </div>
            <div class="col-6 col-sm-3 col-md-2">
                <input type="text" class="inputReceiptSaleProductPrice form-control" placeholder="Precio" readonly>
            </div>
            <div class="col-12 col-sm-3 col-md-2">
                <input type="text" class="inputReceiptSaleSubtotal form-control" placeholder="Subtotal" readonly>                    
            </div>
            <div class="d-none">
                <input type="hidden" name="product_id" class="inputReceiptSaleProductId" value="">
            </div>
            <div class="d-none">
                <input type="hidden" name="minimun_stock" class="inputReceiptSaleMinimunStock" value="">
            </div>
            <div class="col-12 col-sm-2 col-md-1 d-flex gap-1">
                <button type="button" class="btn btn-primary add-product-button w-100" aria-label="Agregar producto">+</button>
                <button type="button" class="btn btn-danger remove-product-button w-100" aria-label="Eliminar producto">&times;</button>
            </div>
        </div>
    `;
    $('#divReceiptSaleDetail').append(productRow);
}

function searchProductName() {
    $(document).on('keyup', '.inputReceiptSaleProduct', async function(event) {
        event.preventDefault();
        if ($(this).val().length < 3) {
            $(this).closest('.product-row').find('.product-suggestions').empty().hide();
            return;
        }

        let productRow = $(this).closest('.product-row');
        let eventRecord = productRow.find('.inputReceiptSaleProduct').val();

        try {
            let eventResultDTO = await search_product_information(eventRecord);

            if (eventResultDTO.result && eventResultDTO.values.productRecords.length > 0) {
                let dropdown = productRow.find('.product-suggestions');
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
                productRow.find('.inputReceiptSaleProductId').val('');
                productRow.find('.product-suggestions').hide();
            }
        } catch (error) {
            productRow.find('.product-suggestions').hide();
            swalResponse(error);
        }
    });

    $(document).on('click', '.suggestion-item', function() {
        let productRow = $(this).closest('.product-row');
        let selectedProductId = $(this).data('id');
        let selectedProductName = $(this).text().trim();
        let selectedProductPrice = $(this).data('price');
        let selectedProductStock = $(this).data('stock');
        let selectedProductMinimunStock = $(this).data('minimum');

        productRow.find('.inputReceiptSaleProduct').val(selectedProductName);
        productRow.find('.inputReceiptSaleProductId').val(selectedProductId);
        productRow.find('.inputReceiptSaleProductPrice').val(selectedProductPrice);
        productRow.find('.inputReceiptSaleMinimunStock').val(selectedProductMinimunStock);

        productRow.data('stock', selectedProductStock);

        productRow.find('.product-suggestions').empty().hide();
    });
}

function checkProductStock(row) {
    let quantity = parseInt(row.find('.inputReceiptSaleQuantity').val()) || 0;
    let stock = parseInt(row.data('stock')) || 0;

    if (quantity > stock) {
        const eventResultDTO = {
            result: false,
            message: 'La cantidad solicitada excede el stock disponible',
        };
        swalResponse(eventResultDTO);
        row.find('.inputReceiptSaleQuantity').val(stock);
    } else {
        checkMinimumStock(row);
    }
}

function checkMinimumStock(row) {
    let stock = parseInt(row.data('stock')) || 0;
    let quantity = parseInt(row.find('.inputReceiptSaleQuantity').val()) || 0;
    let futureStock = stock - quantity;
    let minimumStock = parseInt(row.find('.inputReceiptSaleMinimunStock').val()) || 0;

    if (futureStock === 0) {
        const eventResultDTO = {
            result: true,
            message: 'El stock ha llegado a cero',
        };
        swalResponse(eventResultDTO);
    } else if (futureStock <= minimumStock) {
        const eventResultDTO = {
            result: true,
            message: 'Se alcanzó el stock mínimo',
        };
        swalResponse(eventResultDTO);
        row.find('.inputReceiptSaleQuantity').val(minimumStock);
    }
}

function calculateSubtotal(row) {
    let quantity = parseInt(row.find('.inputReceiptSaleQuantity').val()) || 0;
    let price = parseFloat(row.find('.inputReceiptSaleProductPrice').val()) || 0;
    let subtotal = quantity * price;

    row.find('.inputReceiptSaleSubtotal').val(subtotal.toFixed(2));
    return subtotal;
}

function calculateTotal() {
    let total = 0;

    $('.product-row').each(function(index, element) {
        total += calculateSubtotal($(element));
    });

    $('#totalSaleAmount').text(total.toFixed(2));
}

function saveReceiptSale() {
    $('#saveReceiptSaleButton').on('click', async function(event) {
        event.preventDefault();

        // Obtener los datos de la venta
        const eventRecord = getSaleData();

        if (!eventRecord) {
            const eventResultDTO = {
                result: false,
                message: 'Complete los campos obligatorios antes de registrar la venta',
            };
            swalResponse(eventResultDTO);
            return;
        }

        // Obtener los datos de los productos de la venta
        const saleProductData = getSaleProductData();

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
        patient_id: parseInt($('.inputReceiptSalePatientId').val()) || 0,
        shift_id: parseInt($('#shift_id').val()) || 0,
        user_id: parseInt($('#inputUserId').val()) || 0,
        total: parseFloat($('#totalSaleAmount').text()) || 0,
        status: 'Pendiente',
        payment_method: 'Efectivo',
        is_active: 1,
        is_suspended: 0,
        is_deleted: 0,
    };
}

function getSaleProductData() {
    // Capturar todos los productos y cantidades de la venta
    const products = [];

    $('.product-row').each(function() {
        const productId = parseInt($(this).find('.inputReceiptSaleProductId').val()) || 0;
        const quantity = parseInt($(this).find('.inputReceiptSaleQuantity').val()) || 0;
        const unit_price = parseFloat($(this).find('.inputReceiptSaleProductPrice').val()) || 0;
        const subtotal = quantity * unit_price;

        products.push({
            product_id: productId,
            quantity: quantity,
            unit_price: unit_price,
            subtotal: subtotal,
            is_active: 1,
        });
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
        // window.location.href = '{{ route('dashboard') }}';
        window.location.href = window.dashboardUrl;
    }, 3000);
}