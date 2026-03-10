$(document).ready(function () {
    let id_empresa = $('#id_empresa_all').val();
    $('#tablaEventos').DataTable({
        "ajax": `/admin/empresa-obtener-eventos/${id_empresa}`,
        "type": "get",
        "order": [[0, "asc"]],
        "responsive": true,
        "fixedHeader": true,
        "columns": [
            { data: 'id' },
            { data: 'empresa' },
            { data: 'nombre' },
            { data: 'fecha_inicio' },
            { data: 'fecha_termino' },
            {
                "data": 'imagen',

                "render": function (data,type, row) {
                    let imagen = '';
                    if (data != null && data != '') {
                        imagen = `<img src="/storage/${data}?v=${row.updated_at}" height="100px">`;
                    }
                    return imagen;
                }
            },
            {
                "data": 'id',

                "render": function (data, type, row) {
                    let botones = '';
                    // console.log(row.status);
                    switch (parseInt(row.status)) {
                        case 1:
                            botones += `<a class="btn btn-warning" onclick="accionEvento(${data},'activar')">Activar</a>`;
                            botones += `<a class="btn btn-secondary" onclick="accionEvento(${data},'cerrar')">Cerrar</a>`;
                            break;
                        case 2:
                            botones += `<a class="btn btn-warning" onclick="accionEvento(${data},'abrir')">Abrir registro</a>`;
                            botones += `<a class="btn btn-secondary" onclick="accionEvento(${data},'cerrar')">Cerrar</a>`;
                            break;
                        case 3:
                            botones += `<a class="btn btn-warning" onclick="accionEvento(${data},'abrir')">Abrir registro</a>`;
                            botones += `<a class="btn btn-warning" onclick="accionEvento(${data},'activar')">Activar</a>`;
                            break;
                        default:
                            break;
                    }
                    botones += `<a class="btn btn-success" href="/admin/evento-preguntas/${btoa(row.id)}">Preguntas</a>`;
                    botones += ` <a class="btn btn-success" onclick="obtenerEvento(${data})" data-bs-toggle="modal" data-bs-target="#modalEditEvento">Editar</a>
                <a class="btn btn-danger" onclick="eliminarEvento(${data})" sffs>Eliminar</a>`;

                    return botones;
                }
            },
            {
                "data": 'id',

                "render": function (data) {
                    return `<a class="btn btn-secondary" href="/evento/registro/${btoa(data)}" target="_blank">Registro</a>`;

                }
            }
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "Registros no disponibles",
            "infoFiltered": "(Mostrando  _MAX_ del total de registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
    });


});


function comprobarDatos() {
    $('#bRegistro').addClass("d-none");
    let nombre = $('#formRegistroEvento #nombre').val();
    let fecha_inicio = $('#formRegistroEvento #fecha_inicio').val();
    let fecha_termino = $('#formRegistroEvento #fecha_termino').val();
    if (nombre != '' && fecha_inicio != '' && fecha_termino) {
        $('#bRegistro').removeClass("d-none");
    }
};
comprobarDatos();

function comprobarDatosEdit() {
    $('#bEditar').addClass("d-none");
    let nombre = $('#formEditarEvento #nombre').val();
    let fecha_inicio = $('#formEditarEvento #fecha_inicio').val();
    let fecha_termino = $('#formEditarEvento #fecha_termino').val();
    if (nombre != '' && fecha_inicio != '' && fecha_termino) {
        $('#bEditar').removeClass("d-none");
    }
};
comprobarDatosEdit();

function registrarEvento() {
    // let data = $('#formRegistroEvento').serialize();
    let form = document.getElementById('formRegistroEvento');
    let data = new FormData(form);
    $.ajax({
        type: "POST",
        url: "/admin/evento/add",
        data: data,
        dataType: "json",
        processData: false,   // ❗ obligatorio
        contentType: false,   // ❗ obligatorio
        success: function (response) {
            if (response) {
                Swal.fire({
                    title: "El evento se ha registrdo correctamente",
                    text: "Se ha ingresado exitosamente",
                    icon: "success",
                    confirmButtonText: "Cerrar",
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Ha ocurrido un error al guardar los datos",
                    icon: "error",
                    confirmButtonText: "Cerrar",
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
function obtenerEvento(id) {
    $("#formEditarEvento #id").val();
    $("#formEditarEvento #id_empresa").val();
    $("#formEditarEvento #nombre").val();
    $("#formEditarEvento #fecha_inicio").val();
    $("#formEditarEvento #fecha_termino").val();
    $("#formEditarEvento #imagenActual").empty();

    let url = `/admin/evento/get/${id}`;
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            // console.log(response);

            $("#formEditarEvento #id").val(response.id);
            $("#formEditarEvento #id_empresa").val(response.id_empresa);
            $("#formEditarEvento #nombre").val(response.nombre);
            $("#formEditarEvento #fecha_inicio").val(response.fecha_inicio);
            $("#formEditarEvento #fecha_termino").val(response.fecha_termino);

            if (response.imagen != null && response.imagen != '') {
                $("#formEditarEvento #imagenActual").append(`<img src="/storage/${response.imagen}" height="100px">`);
            }
        }
    });
}


function editarEvento() {
    // let data = $('#formEditarEvento').serialize();

    let form = document.getElementById('formEditarEvento');
    let data = new FormData(form);
    $.ajax({
        type: "POST",
        url: "/admin/evento/update",
        data: data,
        dataType: "json",
        processData: false,   // ❗ obligatorio
        contentType: false,   // ❗ obligatorio
        success: function (response) {
            if (response.ok) {
                Swal.fire({
                    title: "El evento se ha actualizado correctamente",
                    text: "Se ha actualizado exitosamente",
                    icon: "success",
                    confirmButtonText: "Cerrar",
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Ha ocurrido un error al guardar los datos",
                    icon: "error",
                    confirmButtonText: "Cerrar",
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

function eliminarEvento(id) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "Se eliminara este registro",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "get",
                url: `/admin/evento/eliminar/${id}`,
                dataType: "json",
                success: function (response) {
                    if (response.ok) {
                        Swal.fire({
                            title: "El evento se ha eliminado correctamente",
                            text: "Se ha eliminado exitosamente",
                            icon: "success",
                            confirmButtonText: "Cerrar",
                        }).then(() => {
                            location.reload(true);
                        });
                    } else {
                        Swal.fire({
                            title: "Ha ocurrido un error al guardar los datos",
                            icon: "error",
                            confirmButtonText: "Cerrar",
                        });
                    }
                }
            });
        }
    })
}



function accionEvento(id, accion) {
    switch (accion) {
        case 'activar':
            Swal.fire({
                title: 'Estas seguro?',
                text: "Se activara este registro",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: `/admin/evento/accion/${id}/${accion}`,
                        dataType: "json",
                        success: function (response) {
                            if (response.ok) {
                                Swal.fire({
                                    title: "El evento se ha activado correctamente",
                                    text: "Se ha desactivado exitosamente",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(() => {
                                    location.reload(true);
                                });
                            } else {
                                Swal.fire({
                                    title: "Ha ocurrido un error al guardar los datos",
                                    icon: "error",
                                    confirmButtonText: "Cerrar",
                                });
                            }
                        }
                    });
                }
            })
            break;
        case 'abrir':
            Swal.fire({
                title: 'Estas seguro?',
                text: "Se abrira el registro",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Activar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: `/admin/evento/accion/${id}/${accion}`,
                        dataType: "json",
                        success: function (response) {
                            if (response.ok) {
                                Swal.fire({
                                    title: "El registro se ha abierto correctamente",
                                    text: "Se ha abierto exitosamente",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(() => {
                                    location.reload(true);
                                });
                            } else {
                                Swal.fire({
                                    title: "Ha ocurrido un error al guardar los datos",
                                    icon: "error",
                                    confirmButtonText: "Cerrar",
                                });
                            }
                        }
                    });
                }
            })
            break;

        case 'cerrar':
            Swal.fire({
                title: 'Estas seguro?',
                text: "Se cerrara este registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: `/admin/evento/accion/${id}/${accion}`,
                        dataType: "json",
                        success: function (response) {
                            if (response.ok) {
                                Swal.fire({
                                    title: "El evento se ha cerrado correctamente",
                                    text: "Se ha cerrado exitosamente",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(() => {
                                    location.reload(true);
                                });
                            } else {
                                Swal.fire({
                                    title: "Ha ocurrido un error al guardar los datos",
                                    icon: "error",
                                    confirmButtonText: "Cerrar",
                                });
                            }
                        }
                    });
                }
            })
            break;

        default:
            break;
    }

}