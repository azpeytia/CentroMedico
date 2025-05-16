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