function comprobarDatos(){
    $('#bRegistro').addClass("d-none");
    var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    let nombre=$('#name').val();
    let email=$('#email').val();
    let password=$('#password').val();
    let cPassword=$('#password_confirmation').val();
    if(nombre!='' && validEmail.test(email) && password.length>=8 && cPassword.length>=8 && (cPassword==password)){
        $('#bRegistro').removeClass("d-none");
    }
};
$('#bRegistro').addClass("d-none");
comprobarDatos();

