$(document).ready(async function () {
    if ($('#inventory-by-shift').length > 0) {
        await loadShiftInformation();
        await loadInventoryInformation();
        exportInventoryToExcel();
        exportInventoryToPDF();
    }
});

const SELECTORS = {
    mysqlDate: '#mysql_date',
    shiftHour: '#shift_hour',
    shiftId: '#shift_id',
};

const ERROR_MESSAGES = {
    shiftStatus: 'El turno no ha sido iniciado',
};

const MESSAGE_ICONS = {
    success: 'success',
    error: 'error',
    warning: 'warning',
    info: 'info',
    question: 'question',
};

async function loadShiftInformation() {
    const eventRecord = $(SELECTORS.shiftHour).val();

    try {
        const eventResultDTO = await get_shift_information(eventRecord);

        if (eventResultDTO.result) {
            const isStarted = eventResultDTO.values.shiftRecords.is_started;

            if (!isStarted) {
                swalResponse({ result: false, message: ERROR_MESSAGES.shiftStatus, icon: MESSAGE_ICONS.warning });

                redirectToHome();
                return;
            }

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
            renderInventoryTable(eventResultDTO.values.inventoryRecords);
            initializeDataTable();
        } else {
            swalResponse(eventResultDTO);

            redirectToHome();
        }
    } catch (error) {
        swalResponse(error);
    }
}

function renderInventoryTable(products) {
    const table = $('#inventoryTable');
    table.empty();

    table.append(getTableHeader());
    const tbody = $('<tbody></tbody>');

    products.forEach(product => {
        tbody.append(getTableRow(product));
    });

    table.append(tbody);
}

function getTableHeader() {
    return `
        <thead style="background-color: #6c757d; color: white">
            <tr>
                <th style="width: 40%">Producto</th>
                <th style="width: 26%">Presentación</th>
                <th style="width: 11%">Cant inicial</th>
                <th style="width: 13%">Cant vendida</th>
                <th style="width: 10%">Cant final</th>
            </tr>
        </thead>
    `;
}

function getTableRow(product) {
    return `
        <tr>
            <td>${product.product.name}</td>
            <td>${product.product.presentation}</td>
            <td style="text-align: center">${product.opening_stock}</td>
            <td style="text-align: center">${product.sold_stock}</td>
            <td style="text-align: center">${product.closing_stock}</td>
        </tr>
    `;
}

function initializeDataTable() {    
    $('#inventoryTable').DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
    });
}

function exportInventoryToExcel() {
    $('#btnExportExcel').on('click', function () {
        // Crear un nuevo libro de Excel
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Inventario');

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

        // Obtener datos de la tabla HTML
        const table = document.getElementById('inventoryTable');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            worksheet.addRow({
                producto: cells[0].innerText,
                presentacion: cells[1].innerText,
                cant_inicial: parseFloat(cells[2].innerText),
                cant_vendida: parseFloat(cells[3].innerText),
                cant_final: parseFloat(cells[4].innerText)
            });
        });

        // Aplicar bordes a todas las celdas
        worksheet.eachRow((row, rowNumber) => {
            row.eachCell((cell) => {
                cell.border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' }
                };
            });
        });

        // Descargar el archivo Excel
        workbook.xlsx.writeBuffer().then((buffer) => {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Reporte_Inventario.xlsx';
            link.click();
        });
    });
}

function exportInventoryToPDF() {
    $('#btnExportPDF').on('click', function () {
        // Crear una instancia de jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Agregar título al PDF
        doc.setFontSize(18);
        doc.text('Reporte de Inventario', 14, 20);

        // Obtener datos de la tabla HTML
        const table = document.getElementById('inventoryTable');
        const rows = table.querySelectorAll('tbody tr');
        const data = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = Array.from(cells).map(cell => cell.innerText);
            data.push(rowData);
        });

        // Definir encabezados
        const headers = [
            ['Producto', 'Presentación', 'Cant inicial', 'Cant vendida', 'Cant final']
        ];

        // Usar jspdf-autotable para generar la tabla
        doc.autoTable({
            head: headers,
            body: data,
            startY: 30,
            styles: { fontSize: 10, cellPadding: 3 },
            headStyles: { fillColor: [108, 117, 125], textColor: 255 }, // Color gris oscuro
        });

        // Descargar el archivo PDF
        doc.save('Reporte_Inventario.pdf');
    });
}

function redirectToHome() {
    setTimeout(() => {
        window.location.href = window.dashboardUrl;
    }, 3000);
}