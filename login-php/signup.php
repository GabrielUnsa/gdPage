<?php
    require 'database.php';

    $msg = '';
    if( !empty( $_POST['nombre'] ) && !empty( $_POST['password'] ) ){
        $sql = "INSERT INTO users ( nombre, apellido, nickname, password ) VALUES ( :nombre, :apellido, :nickname, :password )";
        $stmt = $conn->prepare( $sql ); #Consulta sql
        $stmt->bindParam( ':nombre', $_POST['nombre'] ); #Vinculacion del parametro Name
        $stmt->bindParam( ':apellido', $_POST['apellido'] );
        $stmt->bindParam( ':nickname', $_POST['nickname'] );
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); #Codificacion de la Password
        $stmt->bindParam(':password', $password); #Vinculacion del parametro Password
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registro </title>
    </head>
    <body>
        <!-- Geting Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Spectral&display=swap" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        
        <?php require 'partials/header.php' ?>

        <h1> Registración </h1>
        <span> o <a href="login.php"> Identificarse </a></span>

        <form action="signup.php" method="POST">
            <input type="text" name="nombre" placeholder="Ingrese su nombre">
            <input type="text" name="apellido" placeholder="Ingrese su apellido">
            <input type="text" name="nickname" placeholder="Ingrese su usuario">
            <input type="password" name="password" placeholder="Ingrese su contraseña">
            <input type="password" name="conf_password" placeholder="Confirme su contraseña">
            <input type="submit" value="Registrar">
        </form>
    </body>
</html>