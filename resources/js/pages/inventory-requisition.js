import { get_product_information } from "../services/productService";

document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('inventory-requisition')) return;
    initializePage();
});

function initializePage() {
    loadProductInformation();
    exportInventoryToExcel();
    exportInventoryToPDF();
}

async function loadProductInformation() {
    try{
        const eventResultDTO = await get_product_information();

        if (!eventResultDTO.result) {
            return swalResponse(eventResultDTO);
        }

        renderProductTable(eventResultDTO.values.productRecords);
        initializeDataTable();
    } catch (error) {
        swalResponse(error);
    }
}

function renderProductTable(products) {
    const table = $('#productTable');
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
                <th style="width: 11%">Cant necesaria</th>
                <th style="width: 13%">Cant actual</th>
                <th style="width: 10%">Cant requerida</th>
            </tr>
        </thead>
    `;
}

function getTableRow(product) {
    return `
        <tr>
            <td>${product.name}</td>
            <td>${product.presentation}</td>
            <td style="text-align: center">${product.max_stock}</td>
            <td style="text-align: center">${product.stock}</td>
            <td style="text-align: center">${product.max_stock - product.stock}</td>
        </tr>
    `;
}

function initializeDataTable() {    
    $('#productTable').DataTable({
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
        const worksheet = workbook.addWorksheet('Requisicion');

        // Definir encabezados con estilos
        worksheet.columns = [
            { header: 'Producto', key: 'producto', width: 40 },
            { header: 'Presentación', key: 'presentacion', width: 26 },
            { header: 'Cant necesaria', key: 'cant_necesaria', width: 11 },
            { header: 'Cant actual', key: 'cant_actual', width: 13 },
            { header: 'Cant requerida', key: 'cant_requerida', width: 10 }
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
        const table = document.getElementById('productTable');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            worksheet.addRow({
                producto: cells[0].innerText,
                presentacion: cells[1].innerText,
                cant_necesaria: parseFloat(cells[2].innerText),
                cant_actual: parseFloat(cells[3].innerText),
                cant_requerida: parseFloat(cells[4].innerText)
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
            link.download = 'Requisicion_Inventario.xlsx';
            link.click();
        });

        redirectToHome();
    });
}

function exportInventoryToPDF() {
    $('#btnExportPDF').on('click', function () {
        // Crear una instancia de jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Agregar título al PDF
        doc.setFontSize(18);
        doc.text('Requisicion de Inventario', 14, 20);

        // Obtener datos de la tabla HTML
        const table = document.getElementById('productTable');
        const rows = table.querySelectorAll('tbody tr');
        const data = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = Array.from(cells).map(cell => cell.innerText);
            data.push(rowData);
        });

        // Definir encabezados
        const headers = [
            ['Producto', 'Presentación', 'Cant necesaria', 'Cant actual', 'Cant requerida']
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
        doc.save('Requisicion_Inventario.pdf');

        redirectToHome();
    });
}

function redirectToHome() {
    window.location.href = window.dashboardUrl;
}