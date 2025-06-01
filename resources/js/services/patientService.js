export function search_patient_information(eventRecord) {
    const url = "/patients/search-patient-information";

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