$(document).ready(function () {
    let id_evento = $("#id_evento_all").val();


    $('#tablaPreguntas').DataTable({
        "ajax": `/admin/evento-preguntas-obtener/${id_evento}`,
        "type": "get",
        "order": [[0, "asc"]],
        // "responsive": true,
        // "fixedHeader": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-secondary'
            }
        ],
        "columns": [
            { data: 'numero' },
            { data: 'pregunta' },
            {
                "data": 'opciones',

                "render": function (data, type, row) {
                    let opciones = data;
                    let respuestas = '';
                    opciones.forEach(element => {
                        respuestas += `${element.numero_respuesta}-${element.respuesta} Conteo: ${element.participaciones}<br>`;
                    });
                    return respuestas;
                }
            },
            {
                "data": 'id',

                "render": function (data, type, row) {
                    return `Participaciones: ${row.participaciones}`;
                }
            },
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
let contador = 1;

function agregarRespuesta() {
    let respuesta = $("#add_respuesta").val();
    if (respuesta != '') {
        $("#respuestas").append(`<input type="text" class="form-control" name="respuestas[]" value="${contador}-${respuesta}" readonly>`);
        $("#add_respuesta").val('');
        contador++;
    } else {
        Swal.fire({
            title: "Introduce un dato",
            icon: "error",
            confirmButtonText: "OK",
        });
    }
}

function comprobarDatos() {
    $('#bRegistro').addClass("d-none");
    let pregunta = $('#formRegistroPregunta #pregunta').val();
    if (pregunta != '') {
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

function registrarPregunta() {
    let data = $('#formRegistroPregunta').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/evento-preguntas-registrar",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response) {
                Swal.fire({
                    title: "La pregunta se ha registrdo correctamente",
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
        }
    });
}


function editarEvento() {
    let data = $('#formEditarEvento').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/evento/update",
        data: data,
        dataType: "json",
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
    if (accion == 'activar') {
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
    } else {
        Swal.fire({
            title: 'Estas seguro?',
            text: "Se desactivara este registro",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Desactivar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: `/admin/evento/accion/${id}/${accion}`,
                    dataType: "json",
                    success: function (response) {
                        if (response.ok) {
                            Swal.fire({
                                title: "El evento se ha desactivado correctamente",
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
    }

}