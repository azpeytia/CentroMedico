function addLeadingZero(number) {
    return number < 10 ? `0${number}` : number;
}

function updateDateTime() {
    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    const hour = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    const dateFormattedMX = `${addLeadingZero(day)}/${addLeadingZero(month)}/${year}`;
    const dateFormattedUS = `${year}-${addLeadingZero(month)}-${addLeadingZero(day)}`;
    const hourFormatted = `${addLeadingZero(hour)}:${addLeadingZero(minutes)}:${addLeadingZero(seconds)}`;

    $('#date').text(dateFormattedMX);
    $('#hour').text(hourFormatted);

    // Formatear fecha y hora para MySQL (YYYY-MM-DD HH:MM:SS)
    const mysqlDate = `${year}-${addLeadingZero(month)}-${addLeadingZero(day)} ${addLeadingZero(hour)}:${addLeadingZero(minutes)}:${addLeadingZero(seconds)}`;
    
    // Asignar a los campos ocultos de main.blade.php
    $('#mysql_date').val(mysqlDate);
    $('#shift_date').val(dateFormattedUS);
    $('#shift_hour').val(hourFormatted);
}

// Hacer las funciones globales
window.addLeadingZero = addLeadingZero;
window.updateDateTime = updateDateTime;