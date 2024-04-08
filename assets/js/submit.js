function uploadFile() {
    var formData = new FormData();
    formData.append('file', selectedFile);
    document.getElementById('uploadBtn').disabled = true;
    document.querySelector('.loadingOverlay').classList.remove('hidden');
    $.ajax({
        url: 'api.php', // URL del script de servidor que maneja la carga del archivo
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            document.querySelector('.loadingOverlay').classList.add('hidden');
            document.querySelector('.link').classList.remove('hidden');
            document.getElementById('fileForm').classList.add('hidden');
            // Actualiza la URL
            document.querySelector('.link a').innerHTML =
                `<i data-feather="link"></i>${response}`;
            document.querySelector('.link a').href = response;
            feather.replace(); // Actualiza el icono
            fileInput.value = ''; // Limpia el archivo seleccionado

        },
        error: function (jqXHR, textStatus, errorMessage) {
            MicroModal.show('dialog-error');
        }
    });
}