
function verificarEvento() {
    let idEvento=$("#idEvento").val();
    let url=`/evento/obtener-estado/${idEvento}`;
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (response) {
            // console.log(response.estado);
            //  console.log(response.url);
            
            if(response.estado==2){
                window.location.href=response.url;
            }else{
                // location.reload();
            }
        }
    });
}



setInterval(function() {
    verificarEvento();
}, 5000);