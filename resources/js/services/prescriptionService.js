export function save_prescription_data(prescriptionData) {
    const url = "/prescriptions/save-prescription-information";
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    return new Promise((resolve, reject) => {
        try {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify(prescriptionData),
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