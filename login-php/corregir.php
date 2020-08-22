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
        
        
        <form id = "FORM" method = "POST" action="update.php"> 
            <label for=''>Capítulo: </label>  
            <input type="text" name ='ncap' id ='ncap' disabled='true' value=" <?php  echo $ncap; ?> ">
            <br>
            <label for=''>Página: </label>
            <input type="text" name ='npag' id ='npag' disabled='true' value="<?php  echo $npag; ?>">
            <br>
            <label for=''>Número de línea: </label>
            <input type="text" name ='nlinea' id ='nlinea' disabled='true' value="<?php  echo $nlinea; ?>">
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
        
        <script type="text/javascript" src="js/index.js"></script>
        <br>
        <a href="seleccion.php"> Volver</a>
        <a href="logout.php"> Salir</a>
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


