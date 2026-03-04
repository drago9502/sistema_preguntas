function notificaciones() {
  $('#notificationes').empty();
  let usuario = $('#userId').val();
  $.ajax({
    type: "get",
    url: `/usuario/notificaciones/get/${usuario}`,
    success: function (response) {

      $('#notificationes').html(`<a onclick="mostrarNotificaciones(${usuario})" data-bs-toggle="modal" data-bs-target="#modalNotificaciones" class="${response.contadorNotificaciones > 0 ? 'text-danger' : ''}"><i class="fas fa-bell " id="bell">${response.contadorNotificaciones}</i></a>`);
      let audio = document.getElementById('notificacionSonido');
      if(response.contadorNotificaciones>0 && response.rolTesoreria==1){
        audio.play().catch(error => {
          console.error('error al repoducir la notificacion', error);
        });
      }
    }
  });

}

notificaciones();

setInterval(function () {
  notificaciones();
}, 120000);




function mostrarNotificaciones(usuario) {
  let url = `/usuario/notificaciones/show/${usuario}`
  $('#notificacionesDiv').empty();
  $.ajax({
    type: "get",
    url: url,
    success: function (response) {
      let notificaciones = response.notificaciones;
      let informacionNotificacion = '';
      if (notificaciones != '') {
        informacionNotificacion += `
          <table id="tablaNotificaciones" style="width: 100%" class="table">
              <thead>
                  <th>
                      Mensaje
                  </th>
                  <th>
                      Acciones
                  </th>
                  </thead>
                  <tbody>`;
        notificaciones.forEach(notificacion => {
          informacionNotificacion += `<tr>
            <td>
              ${notificacion.mensaje}
            </td>
            <td>
            <a notificacionId="${notificacion.id}" link="${notificacion.link}" usuario="${usuario}" class="btn btn-success" onclick="leerNotificacion(${notificacion.id})">${notificacion.link != '' ? 'Revisar' : 'Marcar como leido'}</a>
            </td>
            </tr>`;
        });
        informacionNotificacion += `</tbody>
          </table>`;
        $('#notificacionesDiv').html(informacionNotificacion);
      } else {
        $('#notificacionesDiv').html(`<h3>Sin notificaciones pendientes</h3>`);
      }
    }
  });
};

function leerNotificacion(notificacion) {
  let url = `/usuario/notificaciones/leerNotificaciones/${notificacion}`;
  $.ajax({
    type: "get",
    url: url,
    success: function (response) {
      if (response.link != '') {

        Swal.fire({
          title: "Notificación leída",
          text: "Notificación leída correctamente",
          icon: "success",
          confirmButtonText: "Cerrar",
        }).then(() => {
          window.open(response.link, '_blank');
          mostrarNotificaciones(response.usuario);
        });
      } else {
        Swal.fire({
          title: "Notificación leída",
          text: "Notificación leída correctamente",
          icon: "success",
          confirmButtonText: "Cerrar",
        }).then(() => {
          mostrarNotificaciones(response.usuario);
        });
      }
    }
  });
}

