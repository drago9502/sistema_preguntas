$(document).ready(function () {
   
cargarTablaPreguntas();

});
let tablaPreguntas; // variable global para la tabla
function cargarTablaPreguntas() {
     let id_evento = $("#id_evento_all").val();

      // Si ya existe la tabla, la destruimos antes de reinicializar
    if ($.fn.DataTable.isDataTable('#tablaPreguntas')) {
        tablaPreguntas.destroy();
    }

    tablaPreguntas=$('#tablaPreguntas').DataTable({
        "ajax": `/admin/evento-preguntas-obtener/${id_evento}`,
        "type": "get",
        "order": [[0, "asc"]],
        // "responsive": true,
        // "fixedHeader": true,
        // dom: 'Bfrtip',
        // buttons: [
        //     {
        //         extend: 'excelHtml5',
        //         text: 'Exportar a Excel',
        //         className: 'btn btn-success'
        //     },
        //     {
        //         extend: 'print',
        //         text: 'Imprimir',
        //         className: 'btn btn-secondary'
        //     }
        // ],
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
             {
                "data": 'id',

                "render": function (data, type, row) {
                    let botones='';
                    if(row.status==1){
                        botones=`<a class="btn btn-danger" onclick="cerrarPregunta(${data})">Finalizar pregunta</a>`;
                    }
                    return botones;
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
}

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
                    // location.reload();
                    cargarTablaPreguntas();
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




function cerrarPregunta(id) {
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
                url: `/admin/evento-preguntas-cerrar/${id}`,
                dataType: "json",
                success: function (response) {
                    if (response.ok) {
                        Swal.fire({
                            title: "La pregunta se ha cerrado correctamente",
                            text: "Se ha cerrado exitosamente",
                            icon: "success",
                            confirmButtonText: "Cerrar",
                        }).then(() => {
                            cargarTablaPreguntas();
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



