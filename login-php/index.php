<?php
    session_start();
    require 'database.php';

    if( isset($_SESSION['user_id']) ){
        $records = $conn->prepare('SELECT idusr, nickname, password FROM users WHERE idusr = :idusr');
        $records->bindParam(':idusr', $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch();
        $user = null;
        if( count($results) > 0 ){
            $user = $results;
        }
    }
?>

<!<!DOCTYPE html>
<html lang="es">
    <head>
        <title> Bienvenidos al GD</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Geting Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Spectral&display=swap" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php require 'partials/header.php' ?>
        <?php if( !empty( $user ) ): ?>
            <br> Bienvenido!.<?= $user['nickname'] ?>
            <br> Sigamos trabajando! 
            <a href="logout.php"> Salir</a>
        <?php else:?> 
            <h1> Login</h1>
            <a href="login.php">Identificarse</a> o 
            <a href="signup.php"> Registrarse</a>
        <?php endif;?>
    </body>
</html>