function callApi(t, n, a, e) {
    let formData = new FormData();

    // Memproses data sebelum mengirimnya
    for (let key in a) {
        if (a.hasOwnProperty(key)) {
            formData.append(key, a[key]);
        }
    }

    let setAuthorization = {};

    try {
        setAuthorization = { Authorization: getAuthorization() };
    } catch (error) {
    }

    let setContentType = false;

    if (t == 'PUT' || t == 'PATCH') {
        formData = new URLSearchParams();
        for (let key in a) {
            if (a.hasOwnProperty(key)) {
                formData.append(key, a[key]);
            }
        }
        formData = formData.toString();
        setContentType = 'application/x-www-form-urlencoded';
    }

    $.ajax({ url: n, type: t, headers: setAuthorization, data: formData, processData: false, contentType: setContentType }).done(function (n) {
        e(n);
    });
}

function getBase64(file, name) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        sessionStorage.setItem(name, reader.result)
    };
    reader.onerror = function (error) {
        console.log('Error: ', error);
    };
}
