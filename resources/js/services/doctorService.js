export function search_doctor_information(eventRecord) {
    const url = "/doctors/search-doctor-information";

    return new Promise((resolve, reject) => {
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