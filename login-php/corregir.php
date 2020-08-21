<?php
    session_start();
    require 'database.php';

    if( isset($_SESSION['user_id']) ){
        $records = $conn->prepare('SELECT idusr, nickname, nombre, apellido, password FROM users WHERE idusr = :idusr');
        $records->bindParam(':idusr', $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch();
        $user = null;
        if( count($results) > 0 ){
            $user = $results;
        }
    }
    ?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Seleccion GD</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body> 
    <?php require 'partials/header.php' ?>
    <?php if( !empty( $user ) ): ?>
        <br> Bienvenido!
        <br> <?= $user['nombre'] ?> <?= $user['apellido']?>
        <br> Sigamos trabajando! 

        <div>
        <h1>Revisar Corrección</h1>

        <?php 
        print_r($_POST);
/*         
        $ncap = $_POST['ncap'];
        $npag = $_POST['npag'];
        $nlinea = $_POST['nlinea'];
        $guemes = 'gd1';
        $sql = "SELECT tocr FROM {$guemes} WHERE 
        ncap = :ncap AND npag = :npag AND nlinea = :nlinea" ;
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam( ':ncap', $ncap );
        $stmt -> bindParam( ':npag', $npag );
        $stmt -> bindParam( ':nlinea', $nlinea );$
        $resultado = $stmt->fetch();
        $tcorrg = $resultado['tocr']; */
        $records = $conn->prepare("SELECT * FROM gd1 WHERE idusr IS NULL LIMIT 1");
        $records->execute();
        $results = $records->fetch();
        $ncap = $results['ncap'];
        $npag = $results['npag'];
        $nlinea = $results['nlinea'];
        $tocr = $results['tocr'];  // print_r ($results); ?>
        
        
        <form id = form method = "POST " action=""> 
            <label for=''>Capítulo: </label>  
            <input type="text" name ='ncap' id ='ncap' value=" <?php  echo $ncap; ?> ">
            <br>
            <label for=''>Página: </label>
            <input type="text" name ='npag' id ='npag' value="<?php  echo $npag; ?>">
            <br>
            <label for=''>Número de línea: </label>
            <input type="text" name ='nlinea' id ='nlinea' value="<?php  echo $nlinea; ?>">
            <br>

            <label for=''>Línea original: </label> 
            <textarea name='tocr' disabled='true'> "<?php  echo $tocr; ?>"</textarea>
            <input class = "copiarTocr" type="button" id="copiarTocr" value="Copiar" />
            
            <br>
            <label for=''>Línea sugerida: </label> <br>
            <textarea name='tsug' disabled='true'> "<?php  echo $tocr; ?>"</textarea>
            <input class = "copiarTsug" type="button" id="copiarTsug" value="Copiar" />
            <br>

            <label for=''>Línea a corregir : </label>
            <textarea name='tcorrg', id='tcorrg'> </textarea> 
            <br>
            <input type='submit', name='siguiente', id='siguiente',value='Siguiente'>
         </form>
        
        <script type="text/javascript" src="js/index.js"></script>
        <br>
        <a href="seleccion.php"> Volver</a>
        <a href="logout.php"> Salir</a>
    <?php endif;?>

    <script type="text/javascript">
        var button = document.getElementById("copiarTocr"),
            input = document.getElementById("tocr");

        button.addEventListener("click", function(event) {
            event.preventDefault();lo
            input.select();
            document.execCommand("copy");
        });
    </script>
    
</body>
</html>

<script type = "text/javascript">
    $(document).ready(function(){
        recargarLista();
        $('#siguiente').click(function(){
            recargarLista();
        });
    })
</script>

<script type = "text/javascript">
    function recargarLista(){

        $.ajax({
            type: "POST",
            url: "update.php",
            //url: $(this).attr('action'),
            data: $(this).serialize(),
            //data: { "ncap": $('#ncap').val(), "npag":$('#npag').val(), "nlinea":$('#nlinea').val()},
            success:function(r){
               // $('#list').html(r)
               alert('AJAX call was successful!');
            },
            error: function() {
                alert('There was some error performing the AJAX call!');
            }
        });
    }
</script>