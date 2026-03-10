function comprobarDatos() {
    $('#bRegistro').addClass("d-none");
    let nombre = $('#FormAddAsistente #nombre').val();
    let apellido_paterno = $('#FormAddAsistente #apellido_paterno').val();
    // let apellido_materno = $('#FormAddAsistente #apellido_materno').val();
    let correo = $('#FormAddAsistente #correo').val();

    if (nombre != '' && apellido_paterno != '' && correo != '') {
        $('#bRegistro').removeClass("d-none");
    }
};
comprobarDatos();

function registrarAsistente() {
    let data = $('#FormAddAsistente').serialize();
    $.ajax({
        type: "POST",
        url: "/evento/registroAsistente",
        data: data,
        dataType: "json",
        success: function (response, textStatus, xhr) {
            if (xhr.status === 200) {
                Swal.fire({
                    title: "El registro se ha registrdo correctamente",
                    text: "Se ha registrado exitosamente",
                    icon: "success",
                    confirmButtonText: "Ok",
                }).then(() => {
                     window.location.href=response.url;
                });
            }
             if (xhr.status === 230) {
                 Swal.fire({
                    title: "Este usuario ya esta registrado en este evento",
                    text: "Se ha obtenido informacion exitosamente",
                    icon: "success",
                    confirmButtonText: "Ok",
                }).then(() => {
                     window.location.href=response.url;
                });
             }
        },
        error: function (errores) {
            Swal.fire({
                title: errores.responseJSON.message,
                icon: "error",
                confirmButtonText: "Cerrar",
            });
        }

    });
}