export function save_doctor_data(doctorData) {
    const url = "/doctors/save-doctor-information";
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
                data: JSON.stringify(doctorData),
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