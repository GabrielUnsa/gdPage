$(document).ready( function(){
    $.ajax({
        type: 'POST',
        url: 'cargar_listas.php', /* Consulta en la base de datos donde extrae, procesa y devuelve el resultado en html */
        data: {'peticion': 'cargas_listas'}
    })
    .done( function( lista_rep ){
        alert('se consiguieron resultados')
    })
    .fail(function(){
        alert('Error al cargar la lista de reproduccion')
    })
})