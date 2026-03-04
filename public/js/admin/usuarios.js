
$('#tablaUsuarios').DataTable({
    "ajax": "/admin/usarios/get",
    "type": "get",
    "order": [[0, "asc"]],
    "responsive": true,
    "fixedHeader": true,
    "columns": [
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        {
            "data": 'id',

            "render": function (data) {
                return `
                <a class="btn btn-success" onclick="obtenerUsuario(${data})" data-bs-toggle="modal" data-bs-target="#modalEditUser">Editar usuario</a>
                <a class="btn btn-danger" onclick="eliminarUsuario(${data})" sffs>Eliminar usuario</a>`;
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
    var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    let nombre = $('#name').val();
    let email = $('#email').val();
    let password = $('#password').val();
    let cPassword = $('#password_confirmation').val();
    if (nombre != '' && validEmail.test(email) && password.length >= 8 && cPassword.length >= 8 && (cPassword == password)) {
        $('#bRegistro').removeClass("d-none");
    }
};
comprobarDatos();

function comprobarDatosEdit() {
    $('#bEditar').addClass("d-none");
    let nombre = $('#name_edit').val();
    let password = $('#password_edit').val();
    if (nombre != '' && password.length >= 8) {
        $('#bEditar').removeClass("d-none");
    }
};
comprobarDatosEdit();
function registrarUsuario() {
    let data = $('#formRegistroUsuario').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/usarios/add",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response) {
                Swal.fire({
                    title: "El usuario se ha registrdo correctamente",
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
function obtenerUsuario(id) {
    $("#name_edit").val();
    $("#email_edit").val();
    $("#id").val();
    let url=`/admin/usario/get/${id}`;
    $('#name_edit').val('');
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            $("#name_edit").val(response.name);
            $("#email_edit").val(response.email);
            $("#id").val(response.id);
        }
    });
}
function editarUsuario() {
    let data=$('#formEditarUsuario').serialize();
    $.ajax({
        type: "POST",
        url: "/admin/usario/update",
        data: data,
        dataType: "json",
        success: function (response) {
          if(response.ok){
              Swal.fire({
                title: "El usuario se ha actualizado correctamente",
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
        }
    });
}

function eliminarUsuario(id) {
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
                url: `/admin/usario/eliminar/${id}`,
                dataType: "json",
                success: function (response) {
                    if (response.ok) {
                        Swal.fire({
                            title: "El usuario se ha eliminado correctamente",
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