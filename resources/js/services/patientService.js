export function search_patient_information(eventRecord) {
    const url = "/patients/search-patient-information";
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