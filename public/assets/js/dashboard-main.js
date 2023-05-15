function callApi(t, n, a, e) {
    let formData = new FormData();

    // Memproses data sebelum mengirimnya
    for (let key in a) {
        if (a.hasOwnProperty(key)) {
            formData.append(key, a[key]);
        }
    }

    $.ajax({ url: n, type: t, headers: { Authorization: getAuthorization() }, data: formData, processData: false, contentType: false, }).done(function (n) {
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
