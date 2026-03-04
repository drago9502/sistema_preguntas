
// Función para abrir un modal si no está visible
function abrirModal(modal) {
    if (!$(modal).hasClass('show')) {
      $(modal).modal('show');
    }
  }
  
  // Función para cerrar todos los modales abiertos
  function cerrarModales() {
    $('.modal').removeClass('show').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
  }
  
  // Delegación de eventos en la tabla para abrir modales
  $('body').on('click', '[data-bs-toggle="modal"]', function() {
    cerrarModales();
    var target = $(this).data('bs-target');
    abrirModal(target);
  });
  
  // Cerrar modales al hacer clic en el botón de cerrar o fuera del modal
  $(document).on('click', '[data-bs-dismiss="modal"]', function() {
    cerrarModales();
  });


  