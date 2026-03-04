let tablaPreguntas; // variable global para la tabla

function cargarTablaPreguntas() {
    let id_evento = $('#id_evento').val();

    // Si ya existe la tabla, la destruimos antes de reinicializar
    if ($.fn.DataTable.isDataTable('#tablaPreguntas')) {
        tablaPreguntas.destroy();
    }

    // Inicializamos la DataTable
    tablaPreguntas = $('#tablaPreguntas').DataTable({
        ajax: `/evento-preguntas-obtener/${id_evento}`,
        type: 'GET',
        order: [[0, "asc"]],
        responsive: true,
        fixedHeader: true,
        columns: [
            { data: 'numero' },
            { data: 'pregunta' },
            {
                data: 'id',
                render: function (data) {
                    return `
                        <a class="btn btn-success" onclick="obtenerPregunta(${data})" data-bs-toggle="modal" data-bs-target="#modalAddRespuesta">Contestar</a>
                    `;
                }
            },
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Registros no disponibles",
            infoFiltered: "(Mostrando  _MAX_ del total de registros)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        },
    });
}
$(document).ready(function () {
    cargarTablaPreguntas();
});

function obtenerPregunta(id_pregunta) {
    $('#formRegistroRespuesta #pregunta').text('');
    $('#formRegistroRespuesta #respuestas').empty();
    $('#formRegistroRespuesta #id_pregunta').val('');
    $.ajax({
        type: "get",
        url: `/evento-pregunta-respuestas/${id_pregunta}`,
        success: function (response) {
            $('#formRegistroRespuesta #id_pregunta').val(response.id);
            $('#formRegistroRespuesta #pregunta').text(response.numero + ".- " + response.pregunta);
            let opciones = response.opciones;
            opciones.forEach(element => {
                $('#formRegistroRespuesta #respuestas').append(`<div class="form-check">
            <input class="form-check-input"
                   type="radio"
                   name="respuesta"
                   value="${element.id}"
                   required>

            <label class="form-check-label">
                ${element.numero_respuesta}.- ${element.respuesta}
            </label>
        </div>`);
            });
        }
    });
}

function registrarRespuesta() {
    let data = $('#formRegistroRespuesta').serialize();
    if ($('input[name="respuesta"]:checked').length === 0) {
        Swal.fire({
            title: 'Selecciona una respuesta',
            icon: "error",
            confirmButtonText: "Cerrar",
        });
    } else {
        $.ajax({
            type: "POST",
            url: "/evento-agregar-respuesta",
            data: data,
            dataType: "json",
            success: function (response, textStatus, xhr) {
                if (xhr.status === 200) {
                    Swal.fire({
                        title: "La respuesta se ha registrdo correctamente",
                        text: "Se ha registrado correctamente",
                        icon: "success",
                        confirmButtonText: "Actualizar",
                    }).then(() => {
                        cerrarModales();
                        cargarTablaPreguntas();
                    });
                } else {
                    Swal.fire({
                        title: "La respuesta ya habia sido registrada",
                        text: "Se encontraron registros",
                        icon: "success",
                        confirmButtonText: "Actualizar",
                    }).then(() => {
                        cerrarModales();
                        cargarTablaPreguntas();
                    });
                }
            },
            error: function (errores) {
                Swal.fire({
                    title: "Ha ocurrido un error al guardar los datos",
                    icon: "error",
                    confirmButtonText: "Cerrar",
                });
            }

        });
    }

}