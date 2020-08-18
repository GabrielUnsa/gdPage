$(document).ready( function(){
    recargaLista();
    $('#gd').change( function(){
       recargaLista(); 
    });
})

function recargaLista(){
    $.ajax({
        type: "POST",
        url: "cargar_lista.php",
        data: "gd= " + $('#gd').text(),
        success:function(r) {
            $('#ncap').html(r);
        } 
    })    
}