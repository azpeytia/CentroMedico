export function get_shift_inventories_information(eventRecord) {
    const url = "/inventories/get-shift-inventories-information";

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "GET",
                url: url,
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

export function save_shift_inventory_information(productRecords) {
    const url = "/inventories/save-shift-inventory-information";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: JSON.stringify(productRecords),
                contentType: "application/json",
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

export function update_shift_inventory_information(productRecords) {
    const url = "/inventories/update-shift-inventory-information";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: JSON.stringify(productRecords),
                contentType: "application/json",
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

export function get_inventory_information(eventRecord) {
    const url = "/inventories/get-inventory-information";
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

export function get_inventory_request_information(eventRecord) {
    const url = "/inventories/get-inventory-request-information";
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

export function update_inventory_stock(productQuantity) {
    const url = "/inventories/update-inventory-stock";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        $.ajax({
            type: "PATCH",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                productQuantity: productQuantity
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
    });
}

export function update_shift_opening_stock(productRecords) {
    const url = "/inventories/update-shift-opening-stock";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: JSON.stringify(productRecords),
                contentType: "application/json",
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