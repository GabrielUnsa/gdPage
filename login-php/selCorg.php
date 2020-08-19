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
    <title>Correccion Guemes Documentado</title>
    <?php require 'partials/header.php' ?>
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Geting Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Spectral&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php if( !empty( $user ) ): ?>
        <p class = 'welcome'> Bienvenido! </p>
        <p class = 'welcome'> <?= $user['nombre'] ?> <?= $user['apellido']?> </p>
        <p class = 'welcome'> Sigamos trabajando! </p>
        <br>
    
    <?php endif;?>
    <a class = 'b1' href="sCorg.php"> Seguir Corrigiendo </a> 
    <a class = 'b2' href="mCorg.php"> Modificar Correccion </a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <a class = 'b3' href="logout.php"> Salir </a>
</body>
</html>