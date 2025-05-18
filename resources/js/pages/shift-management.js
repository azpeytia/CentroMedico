$(document).ready(function() {
    initializePage();
});

function initializePage() {
    loadShiftInformation();
    loadProductInformation();
    closeCurrentShift();
    runInventoryRequest();
}

async function loadShiftInformation() {
    try {
        const eventRecord = $('#shift_hour').val();

        // Obtiene información del turno actual
        const eventResultDTO = await get_shift_information(eventRecord);

        if (eventResultDTO.result) {
            updateShiftInputs(eventResultDTO.values.shiftRecords);
            updateShiftButtons(eventResultDTO.values.shiftRecords.is_started);

            // Asigna el nombre del turno al campo de texto
            $('#shift').text(eventResultDTO.values.shiftRecords.name);

            // Verifica si hay turnos sin cerrar diferentes al actual
            checkAnyShiftOpen();

            // Verifica si el turno actual está iniciado y terminado anteriormente
            checkCurrentShiftStatus();
        } else {
            $('#shift').text('No hay turnos activos en este momento');
            swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

function updateShiftInputs(shiftRecords) {
    // Asigna valores a los inputs ocultos
    $('#shift_name').val(shiftRecords.name);
    $('#shift_id').val(shiftRecords.id);
    $('#shift_status').val(shiftRecords.is_started);
}

function updateShiftButtons(isStarted) {
    // Habilita o deshabilita los botones según el estado del turno
    if (isStarted == 0) {
        $('#btnStartShift').prop('disabled', false);
        $('#btnEndShift').prop('disabled', true);
    } else {
        $('#btnStartShift').prop('disabled', true);
        $('#btnEndShift').prop('disabled', false);
    }
}

async function checkAnyShiftOpen() {
    const eventRecord = $('#shift_id').val();

    try {
        const eventResultDTO = await get_previous_shift_status(eventRecord);

        if (eventResultDTO.result) {
            updateShiftButtons(eventResultDTO.values.shiftRecords.is_started);
            swalResponse(eventResultDTO);

            closePreviousShift();
        } else {
            //swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

async function closePreviousShift() {
    const eventRecord = $('#shift_id').val();

    try {
        const eventResultDTO = await update_previous_status(eventRecord);

        if (eventResultDTO.result) {
            swalResponse(eventResultDTO);

            redirectToHome();
        } else {
            swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

async function checkCurrentShiftStatus() {
    const eventRecord = {shiftId: $('#shift_id').val(), shiftDate: $('#shift_date').val()};

    try {
        const eventResultDTO = await get_current_shift_status(eventRecord);

        if (eventResultDTO.result) {
            $('#btnStartShift').prop('disabled', true);
            $('#btnEndShift').prop('disabled', true);
            $('#btnInventoryRequest').prop('disabled', false);

            swalResponse(eventResultDTO);
        } else {
            //swalResponse(eventResultDTO);
        }
    } catch (error) {
        swalResponse(error);
    }
}

function loadProductInformation() {
    $('#btnStartShift').click(async function(event) {
        event.preventDefault();

        try {
            const productInformation = await get_product_information();

            if (!productInformation.result) {
                return handleResponse(productInformation);
            }

            const shiftId = $('#shift_id').val();
            const shiftDate = $('#shift_date').val();

            const productRecords = mapProductRecords(productInformation.values.productRecords, shiftId, shiftDate);

            await processShiftStart(productRecords, shiftId);
        } catch (error) {
            swalResponse(error);
        }
    });
}

function mapProductRecords(productRecords, shiftId, shiftDate) {
    return productRecords.map(product => ({
        productId: product.id,
        productStock: product.stock,
        shiftId: shiftId,
        shiftDate: shiftDate,
    }));
}

async function processShiftStart(productRecords, shiftId) {
    const eventResultDTO = await save_shift_inventory_information(productRecords);
    handleResponse(eventResultDTO, true);

    if (eventResultDTO.result) {
        const shiftRecord = { shiftId: shiftId, isStarted: 1, isFinished: 0 };
        console.log(shiftRecord);
        await update_shift_status(shiftRecord);

        redirectToHome();
    }
}

function handleResponse(eventResultDTO, updateButtons = false) {
    if (eventResultDTO.result && updateButtons) {
        toggleShiftButtons(true);
    }
    swalResponse(eventResultDTO);
}

function toggleShiftButtons(isShiftStarted) {
    $('#btnStartShift').prop('disabled', isShiftStarted);
    $('#btnEndShift').prop('disabled', !isShiftStarted);
}

function redirectToHome() {
    setTimeout(() => {
        // window.location.href = '{{ route('dashboard') }}';
        window.location.href = window.dashboardUrl;
    }, 3000);
}

function closeCurrentShift() {
    $('#btnEndShift').click(async function(event) {
        event.preventDefault();

        try {
            const productInformation = await get_product_information();
            const shiftId = $('#shift_id').val();
            const shiftDate = $('#shift_date').val();

            if (productInformation.result) {
                const productRecords = productInformation.values.productRecords.map(product => ({
                    productId: product.id,
                    shiftId: shiftId,
                    shiftDate: shiftDate,
                }));

                const eventResultDTO = await update_shift_inventory_information(productRecords);

                if (eventResultDTO.result) {
                    $('#btnEndShift').prop('disabled', true);
                    $('#btnInventoryRequest').prop('disabled', false);

                    swalResponse(eventResultDTO);

                    const shiftRecord = { shiftId: shiftId, isStarted: 0, isFinished: 1 };
                    await update_shift_status(shiftRecord);
                } else {
                    swalResponse(eventResultDTO);
                }
            } else {
                swalResponse(eventResultDTO);
            }
        } catch (error) {
            swalResponse(error);
        }
    });
}

function runInventoryRequest() {
    $('#btnInventoryRequest').click(async function(event) {
        event.preventDefault();

        const eventRecord = {
                shiftId: $('#shift_id').val(),
                shiftDate: $('#shift_date').val(),
            };

        try {
            const eventResultDTO = await get_inventory_request_information(eventRecord);

            if (eventResultDTO.result) {
                // Crear un nuevo libro de Excel
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Requisición');

                // Definir encabezados con estilos
                worksheet.columns = [
                    { header: 'Producto', key: 'producto', width: 40 },
                    { header: 'Presentación', key: 'presentacion', width: 26 },
                    { header: 'Cant inicial', key: 'cant_inicial', width: 11 },
                    { header: 'Cant vendida', key: 'cant_vendida', width: 13 },
                    { header: 'Cant final', key: 'cant_final', width: 10 }
                ];

                // Aplicar estilos a los encabezados
                worksheet.getRow(1).font = { bold: true, color: { argb: 'FFFFFFFF' } };
                worksheet.getRow(1).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FF4CAF50' } // Verde
                };
                worksheet.getRow(1).alignment = { horizontal: 'center', vertical: 'middle' };

                // Se recorre el arreglo inventoryRequestRecords y agregar los datos a la hoja
                const productRecords = eventResultDTO.values.inventoryRequestRecords;

                productRecords.forEach(record => {
                    worksheet.addRow({
                        producto: record.product.name,
                        presentacion: record.product.presentation,
                        cant_inicial: record.opening_stock,
                        cant_vendida: record.sold_stock,
                        cant_final: record.closing_stock,
                    });
                });

                // Agrega los datos a la hoja
                /* productRecords.forEach(record => {
                    worksheet.addRow(record);
                }); */

                // Genera el archivo Excel como un Blob
                const buffer = await workbook.xlsx.writeBuffer();

                // Crea un enlace para descargar el archivo
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Requisicion.xlsx';
                a.click();
                URL.revokeObjectURL(url);
                
                swalResponse(eventResultDTO);
            } else {
                swalResponse(eventResultDTO);
            }
        } catch (error) {
            swalResponse(error);
        }
    });
}