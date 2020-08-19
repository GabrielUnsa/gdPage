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
    <?php require 'partials/header.php' ?>
    <?php if( !empty( $user ) ): ?>
        <br> Bienvenido!
        <br> <?= $user['nombre'] ?> <?= $user['apellido']?>
        <br> Sigamos trabajando! 

        <div>
        <h1>Revisar Corrección</h1>

        <?php 
        
        $gd = 'gd1';
        $consulta = $conn->prepare("SELECT * FROM $gd limit 1;") ;
        $consulta->execute();
        $resultado = $consulta->fetch();
        $ncap = $resultado['ncap'];
        $npag = $resultado['npag'];
        $nlinea = $resultado['nlinea'];
        $tcorrg = $resultado['tocr'];
        echo "
            <form action='update.php' method='POST' target='_blank'>   
            <label for=''>Tomo: </label>
            <input type='text', disabled='true', value=".$ncap.">
            <br>
            <label for=''>Capítulo: </label>
            <input type='text', disabled='true', value=".$npag.">
            <br>
            <label for=''>Página: </label>
            <input type='text', disabled='true', value=".$nlinea.">
            <br>
            <label for=''>Línea corregida: </label>
            
            <p><textarea name='tcorrg', disabled='true'> ".$tcorrg."</textarea> </p>
            <label for=''>Modificar : </label>

            <textarea name='tmod',rows='5',cols='100'> ".$tcorrg."</textarea> 
            <br>
            <input type='submit' value='Siguiente'>
            </form>   
            ";
            //print_r ($resultado);
            

        ?>
        
        </div>
        
        <script type="text/javascript" src="js/index.js"></script>
        <br>
        <a href="logout.php"> Salir</a>
    <?php endif;?>
</head>
<body>
    
</body>
</html>