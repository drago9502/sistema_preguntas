
$('#tablaEmpresas').DataTable({
    "ajax": "/admin/empresas/get",
    "type": "get",
    "order": [[0, "asc"]],
    "responsive": true,
    "fixedHeader": true,
    "columns": [
        { data: 'id' },
        { data: 'nombre' },
        {
            "data": 'id',

            "render": function (data) {
                return `
                <a class="btn btn-success" onclick="obtenerEmpresa(${data})" data-bs-toggle="modal" data-bs-target="#modalEditEmpresa">Editar</a>
                <a class="btn btn-secondary" href="/admin/empresa-eventos/${data}">Eventos</a>
                <a class="btn btn-danger" onclick="eliminarEmpresa(${data})">Eliminar</a>`;
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

function comprobarDatos() {
    $('#bRegistro').addClass("d-none");
    let nombre = $('#formRegistroEmpresa #nombre').val();
    if (nombre != '') {
        $('#bRegistro').removeClass("d-none");
    }
};
comprobarDatos();

function comprobarDatosEdit() {
    $('#bEditar').addClass("d-none");
    let nombre = $('#formEditarEmpresa #nombre').val();
    if (nombre != '') {
        $('#bEditar').removeClass("d-none");
    }
};
comprobarDatosEdit();

function registrarEmpresa() {
    let data = $('#formRegistroEmpresa').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/empresa/add",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response) {
                Swal.fire({
                    title: "La empresa se ha registrdo correctamente",
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
function obtenerEmpresa(id) {
    $("#formEditarEmpresa #nombre").val();
    $("#formEditarEmpresa #id").val();
    let url = `/admin/empresa/get/${id}`;
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            $("#formEditarEmpresa #nombre").val(response.nombre);
            $("#formEditarEmpresa #id").val(response.id);
        }
    });
}


function editarEmpresa() {
    let data = $('#formEditarEmpresa').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/empresa/update",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.ok) {
                Swal.fire({
                    title: "La empresa se ha actualizado correctamente",
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

function eliminarEmpresa(id) {
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
                url: `/admin/empresa/eliminar/${id}`,
                dataType: "json",
                success: function (response) {
                    if (response.ok) {
                        Swal.fire({
                            title: "La empresa se ha eliminado correctamente",
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