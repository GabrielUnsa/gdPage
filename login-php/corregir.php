<?php
    session_start();
    require 'database.php';

    if( isset($_SESSION['user_id']) ){
        $records = $conn->prepare('SELECT idusr FROM users WHERE idusr = :idusr');
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
    <title>Correcion GD</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body> 
    <?php require 'partials/header.php' ?>
    <?php if( !empty( $user ) ): ?>
        <div>
        <h1>Revisar Corrección</h1>
        <?php 
        $records = $conn->prepare("SELECT tocr FROM {$_POST['GD']} WHERE ncap = :ncap AND npag = :npag AND nline = :nline");
        $records->bindParam(':ncap', $_POST['ncap']);
        $records->bindParam(':npag', $_POST['npag']);
        $records->bindParam(':nline', $_POST['nline']);
        $records->execute();
        $results = $records->fetch();
        $ncap = $_POST['ncap'];
        $npag = $_POST['npag'];
        $nline = $_POST['nline'];
        $tocr = $results[0]; ?>
        
        
        <form id = "FORM" method = "POST" action="update.php"> 

            <label for=''>Capítulo: </label>  
            <input type="text" name ='ncap' id ='ncap' readonly='true' value=" <?php  echo $ncap; ?> ">
            <br>
            <label for=''>Página: </label>
            <input type="text" name ='npag' id ='npag' readonly='true' value="<?php  echo  $npag; ?>">
            <br>
            <label for=''>Número de línea: </label>
            <input type="text" name ='nlinea' id ='nlinea' readonly='true' value="<?php  echo $nline; ?>">
            <br>

            <label for=''>Línea original: </label> 
            <textarea name='tocr' id="tocr" disabled ='true'> "<?php  echo $tocr; ?>"</textarea>
            <input class = "copiar" type="button" id="copiarTocr" value="Copiar para editar" onclick="copy()" />
            <br>

            <label for=''>Línea sugerida: </label> <br>
            <textarea name='tsug' id="tsug" disabled='true'> "<?php  echo $tocr; ?>"</textarea>
            <input class = "copiar" type="button" id="copiarTsug" value="Copiar para editar" onclick="copy2()" />
            <br>

            <label for=''>Línea a corregir : </label>
            <textarea name='tcorrg' id="tcorrg" > </textarea>

            <br>
            <input type='submit' name='siguiente' id='siguiente' value='Siguiente'>
         </form>
        <br>
        <a class = b2v href="seleccion.php"> Volver</a>
        <a class = b3v href="logout.php"> Salir</a>
        <br>
    <?php endif;?>
    
    <script type="text/javascript">
        function copy() {
            $("#tcorrg").val(document.getElementById("tocr").value);
        }
        function copy2() {
            $("#tcorrg").val(document.getElementById("tsug").value); 
        }
    </script>

    
</body>
</html>


