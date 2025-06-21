export function get_product_information() {
    const url = "/products/get-product-information";

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "GET",
                url: url,
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

export function load_product_information(gtinBarCode) {
    return $.ajax({
        type: "GET",
        url: "/products/load-product-information",
        data: { gtinBarCode },
        dataType: "json"
    });
}

export function search_product_information(eventRecord) {
    const url = "/products/search-product-information";
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

export function update_product_stock(productQuantity) {
    const url = "/products/update-product-stock";
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

export function update_restock_inventory_information(eventRecord) {
    const url = "/products/update-restock-inventory-information";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "POST",
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