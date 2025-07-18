import { get_sale_information } from "../../services/saleService";
let localStartTime, localEndTime;
let salesByShift = 0, salesByDay = 0, salesByWeek = 0, salesByMonth = 0, salesByYear = 0;

document.addEventListener('DOMContentLoaded', async function() {
    await loadShiftInformation();
    if (!document.getElementById('sales-analysis')) return;
    initializePage();
});

function initializePage() {
    Promise.all([
        loadSalesByShift(),
        loadSalesByDay(),
        loadSalesByWeek(),
        loadSalesByMonth(),
        loadSalesByYear()
    ]).then(() => {
        initializeSalesComparisonChart();
    });
}

async function loadShiftInformation() {
    const eventRecord = document.getElementById('shift_hour').value;

    try {
        const eventResultDTO = await get_shift_information(eventRecord);

        if (eventResultDTO.result) {
            const startTimeISO = eventResultDTO.values.shiftRecords.start_time;
            const endTimeISO = eventResultDTO.values.shiftRecords.end_time;
            localStartTime = new Date(startTimeISO);
            localEndTime = new Date(endTimeISO);
        }
    } catch (error) {
        swalresponse(error);
    }
}

async function loadSalesByShift() {
    const eventRecord = {
        startDate: formatDateToMySQL(localStartTime),
        endDate: formatDateToMySQL(localEndTime),
        category: 'shift',
    };

    try {
        const eventResultDTO = await get_sale_information(eventRecord);

        if (eventResultDTO.result) {
            document.getElementById('sales-shift-value').textContent =
                '$' + Number(eventResultDTO.values.sales).toLocaleString();
            salesByShift = Number(eventResultDTO.values.sales) || 0;
            } else {
            document.getElementById('sales-shift-value').textContent = '$0';
        }
    } catch (error) {
        swalresponse(error);
    }
}

async function loadSalesByDay() {
    const today = new Date();
    const startOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    const endOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);

    const eventRecord = {
        startDate: formatDateToMySQL(startOfDay),
        endDate: formatDateToMySQL(endOfDay),
        category: 'day',
    };

    try {
        const eventResultDTO = await get_sale_information(eventRecord);

        if (eventResultDTO.result) {
            document.getElementById('sales-day-value').textContent =
                '$' + Number(eventResultDTO.values.sales).toLocaleString();
            salesByDay = Number(eventResultDTO.values.sales) || 0;
            } else {
            document.getElementById('sales-day-value').textContent = '$0';
        }
    } catch (error) {
        swalresponse(error);
    }
}

async function loadSalesByWeek() {
    const today = new Date();
    const startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay());
    const endOfWeek = new Date(today.getFullYear(), today.getMonth(), startOfWeek.getDate() + 6);

    const eventRecord = {
        startDate: formatDateToMySQL(startOfWeek),
        endDate: formatDateToMySQL(endOfWeek),
        category: 'week',
    };

    try {
        const eventResultDTO = await get_sale_information(eventRecord);

        if (eventResultDTO.result) {
            document.getElementById('sales-week-value').textContent =
                '$' + Number(eventResultDTO.values.sales).toLocaleString();
            salesByWeek = Number(eventResultDTO.values.sales) || 0;
            } else {
            document.getElementById('sales-week-value').textContent = '$0';
        }
    } catch (error) {
        swalresponse(error);
    }
}

async function loadSalesByMonth() {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    startOfMonth.setHours(0, 0, 0);
    endOfMonth.setHours(23, 59, 59);

    const eventRecord = {
        startDate: formatDateToMySQL(startOfMonth),
        endDate: formatDateToMySQL(endOfMonth),
        category: 'month',
    };

    try {
        const eventResultDTO = await get_sale_information(eventRecord);

        if (eventResultDTO.result) {
            document.getElementById('sales-month-value').textContent = 
                '$' + Number(eventResultDTO.values.sales).toLocaleString();
            salesByMonth = Number(eventResultDTO.values.sales) || 0;
            } else {
            document.getElementById('sales-month-value').textContent = '$0';
        }
    } catch (error) {
        swalresponse(error);
    }
}

async function loadSalesByYear() {
    const today = new Date();
    const startOfYear = new Date(today.getFullYear(), 0, 1, 0, 0, 0);
    const endOfYear = new Date(today.getFullYear(), 11, 31, 23, 59, 59);

    const eventRecord = {
        startDate: formatDateToMySQL(startOfYear),
        endDate: formatDateToMySQL(endOfYear),
        category: 'year',
    };

    try {
        const eventResultDTO = await get_sale_information(eventRecord);

        salesByYear = eventResultDTO.result ? Number(eventResultDTO.values.sales) : 0;
    } catch (error) {
        salesByYear = 0;
    }
}

function formatDateToMySQL(date) {
    const pad = num => String(num).padStart(2, '0');

    const year = date.getFullYear();
    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const hours = pad(date.getHours());
    const minutes = pad(date.getMinutes());
    const seconds = pad(date.getSeconds());

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function initializeSalesComparisonChart() {
    const ctx = document.getElementById('salesComparisonChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Turno', 'Día', 'Semana', 'Mes', 'Año'],
            datasets: [{
                label: 'Ventas',
                data: [salesByShift, salesByDay, salesByWeek, salesByMonth, salesByYear],
                backgroundColor: [
                    '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'
                ],
                borderColor: [
                    '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
}