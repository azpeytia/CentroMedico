export function swalResponse(eventResultDTO) {
    if (eventResultDTO.result) {
        Swal.fire({
            icon: eventResultDTO.icon,
            title: 'Correcto',
            text: eventResultDTO.message,
            showConfirmButton: true,
            confirmButtonText: 'Ok',
            timer: 4500
        });
    } else {
        Swal.fire({
            icon: eventResultDTO.icon,
            title: 'Error',
            text: eventResultDTO.message,
            showConfirmButton: true,
            confirmButtonText: 'Ok',
            timer: 4500
        });
    }
}