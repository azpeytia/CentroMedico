export function get_shift_information(eventRecord) {
    const url = "/shifts/get-shift-information";

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "GET",
                url: url,
                data: { eventRecord },
                dataType: "json",
                success: function(eventResultDTO) {
                    resolve(eventResultDTO);
                },
                error: function(errors) {
                    var data = errors.responseJSON;
                    reject(data);
                }
            });
        } catch (error) {
            reject(error);
        }
    });
}

export function get_previous_shift_status(eventRecord) {
    const url = "/shifts/get-previous-shift-status";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    eventRecord: eventRecord
                },
                dataType: "json",
                success: function(eventResultDTO) {
                    resolve(eventResultDTO);
                },
                error: function(errors) {
                    var data = errors.responseJSON;
                    reject(data);
                }
            });
        } catch (error) {
            reject(error);
        }
    });
}

export function get_current_shift_status(eventRecord) {
    const url = "/shifts/get-current-shift-status";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    eventRecord: eventRecord
                },
                dataType: "json",
                success: function(eventResultDTO) {
                    resolve(eventResultDTO);
                },
                error: function(errors) {
                    var data = errors.responseJSON;
                    reject(data);
                }
            });
        } catch (error) {
            reject(error);
        }
    });
}

export function update_shift_status(shiftRecord) {
    const url = "/shifts/update-shift-status";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    eventRecord: shiftRecord
                },
                dataType: "json",
                success: function(eventResultDTO) {
                    resolve(eventResultDTO);
                },
                error: function(errors) {
                    var data = errors.responseJSON;
                    reject(data);
                }
            });
        } catch (error) {
            reject(error);
        }
    });
}

export function update_previous_status(eventRecord) {
    const url = "/shifts/update-previous-shift-status";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    eventRecord: eventRecord
                },
                dataType: "json",
                success: function(eventResultDTO) {
                    resolve(eventResultDTO);
                },
                error: function(errors) {
                    var data = errors.responseJSON;
                    reject(data);
                }
            });
        } catch (error) {
            reject(error);
        }
    });
}