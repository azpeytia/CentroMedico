import { get_sale_information } from "../../services/saleService";
let localStartTime = null, localEndTime = null, salesChartInstance = null;
let salesByShift = 0, salesByDay = 0, salesByWeek = 0, salesByMonth = 0, salesByYear = 0;

document.addEventListener('DOMContentLoaded', async function() {
    await loadShiftInformation();
    if (!document.getElementById('sales-analysis')) return;
    initializePage();
    document.getElementById('btn-shift').addEventListener('click', async function() {
        setActiveButton(this);
        const data = await getSalesByHourOfShift();
        updateSalesComparisonChart(data.labels, data.values, 'Ventas por Hora');
    });
    document.getElementById('btn-day').addEventListener('click', async function() {
        setActiveButton(this);
        const data = await getSalesByTurnOfDay();
        updateSalesComparisonChart(data.labels, data.values, 'Ventas por Turno');
    });
    document.getElementById('btn-week').addEventListener('click', async function() {
        setActiveButton(this);
        const data = await getSalesByDayOfWeek();
        updateSalesComparisonChart(data.labels, data.values, 'Ventas por Día');
    });
    document.getElementById('btn-month').addEventListener('click', async function() {
        setActiveButton(this);
        const data = await getSalesByWeekOfMonth();
        updateSalesComparisonChart(data.labels, data.values, 'Ventas por Semana');
    });
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

function setActiveButton(btn) {
    document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function initializeSalesComparisonChart() {
    const ctx = document.getElementById('salesComparisonChart').getContext('2d');
    salesChartInstance = new Chart(ctx, {
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

// Actualiza la gráfica con nuevos datos
function updateSalesComparisonChart(labels, values, label) {
    salesChartInstance.data.labels = labels;
    salesChartInstance.data.datasets[0].data = values;
    salesChartInstance.data.datasets[0].label = label;
    salesChartInstance.update();
}

// Obtiene ventas por hora del turno actual
async function getSalesByHourOfShift() {
    // Suponiendo que localStartTime y localEndTime están definidos
    const labels = [];
    const values = [];
    let current = new Date(localStartTime);
    while (current < localEndTime) {
        const next = new Date(current);
        next.setHours(current.getHours() + 1);
        labels.push(current.getHours() + ':00');
        const eventRecord = {
            startDate: formatDateToMySQL(current),
            endDate: formatDateToMySQL(next),
            category: 'hour',
        };
        console.log(eventRecord);
        try {
            const eventResultDTO = await get_sale_information(eventRecord);
            values.push(eventResultDTO.result ? Number(eventResultDTO.values.sales) : 0);
        } catch {
            values.push(0);
        }
        current = next;
    }
    return { labels, values };
}

// Obtiene ventas por turno del día actual
async function getSalesByTurnOfDay() {
    // Define los turnos según tu lógica de negocio
    const turnos = [
        { label: 'Mañana', start: 7, end: 13 },
        { label: 'Tarde', start: 13, end: 23 },
        { label: 'Noche', start: 23, end: 7 } // Noche abarca desde las 23 hasta las 7 del día siguiente
    ];
    const today = new Date();
    const labels = [];
    const values = [];
    for (const turno of turnos) {
        const start = new Date(today.getFullYear(), today.getMonth(), today.getDate(), turno.start, 0, 0);
        const end = new Date(today.getFullYear(), today.getMonth(), today.getDate(), turno.end, 0, 0);
        labels.push(turno.label);
        const eventRecord = {
            startDate: formatDateToMySQL(start),
            endDate: formatDateToMySQL(end),
            category: 'shift',
        };
        try {
            const eventResultDTO = await get_sale_information(eventRecord);
            values.push(eventResultDTO.result ? Number(eventResultDTO.values.sales) : 0);
        } catch {
            values.push(0);
        }
    }
    return { labels, values };
}

// Obtiene ventas por día de la semana actual
async function getSalesByDayOfWeek() {
    const labels = [];
    const values = [];
    const today = new Date();
    const startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay());
    for (let i = 0; i < 7; i++) {
        const day = new Date(startOfWeek.getFullYear(), startOfWeek.getMonth(), startOfWeek.getDate() + i);
        labels.push(day.toLocaleDateString('es-ES', { weekday: 'short' }));
        const start = new Date(day.getFullYear(), day.getMonth(), day.getDate(), 0, 0, 0);
        const end = new Date(day.getFullYear(), day.getMonth(), day.getDate(), 23, 59, 59);
        const eventRecord = {
            startDate: formatDateToMySQL(start),
            endDate: formatDateToMySQL(end),
            category: 'day',
        };
        try {
            const eventResultDTO = await get_sale_information(eventRecord);
            values.push(eventResultDTO.result ? Number(eventResultDTO.values.sales) : 0);
        } catch {
            values.push(0);
        }
    }
    return { labels, values };
}

// Obtiene ventas por semana del mes actual
async function getSalesByWeekOfMonth() {
    const labels = [];
    const values = [];
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth();
    let weekStart = new Date(year, month, 1);
    let weekNum = 1;
    while (weekStart.getMonth() === month) {
        const weekEnd = new Date(weekStart.getFullYear(), weekStart.getMonth(), weekStart.getDate() + 6, 23, 59, 59);
        labels.push('Semana ' + weekNum);
        const eventRecord = {
            startDate: formatDateToMySQL(weekStart),
            endDate: formatDateToMySQL(weekEnd),
            category: 'week',
        };
        try {
            const eventResultDTO = await get_sale_information(eventRecord);
            values.push(eventResultDTO.result ? Number(eventResultDTO.values.sales) : 0);
        } catch {
            values.push(0);
        }
        weekStart = new Date(weekStart.getFullYear(), weekStart.getMonth(), weekStart.getDate() + 7);
        weekNum++;
    }
    return { labels, values };
}