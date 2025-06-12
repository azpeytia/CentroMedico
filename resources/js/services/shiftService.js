function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

export function get_shift_information(eventRecord) {
    return $.ajax({
        type: "GET",
        url: "/shifts/get-shift-information",
        data: { eventRecord },
        dataType: "json"
    });
}

export function get_previous_shift_status(eventRecord) {
    return $.ajax({
        type: "GET",
        url: "/shifts/get-previous-shift-status",
        data: { eventRecord },
        dataType: "json"
    });
}

export function get_current_shift_status(eventRecord) {
    return $.ajax({
        type: "GET",
        url: "/shifts/get-current-shift-status",
        data: { eventRecord },
        dataType: "json"
    });
}

export function update_shift_status(shiftRecord) {
    return $.ajax({
        type: "PATCH",
        url: "/shifts/update-shift-status",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        },
        data: { eventRecord: shiftRecord },
        dataType: "json"
    });
}

export function update_previous_shift_status(eventRecord) {
    return $.ajax({
        type: "PATCH",
        url: "/shifts/update-previous-shift-status",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        },
        data: { eventRecord },
        dataType: "json"
    });
}