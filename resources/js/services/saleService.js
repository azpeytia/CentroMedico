export function save_sale_information(eventRecord) {
    const url = "/sales/save-sale-information";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve,reject) => {
        try {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify(eventRecord),
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