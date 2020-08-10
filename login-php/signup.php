<?php
    require 'database.php';

    $msg = '';
    if( !empty( $_POST['Nombre'] ) && !empty( $_POST['Password'] ) ){
        $sql = "INSERT INTO users ( Nombre, Password ) VALUES ( :Name, :Password )";
        $stmt = $conn->prepare( $sql ); #Consulta sql
        $stmt->bindParam( ':Name', $_POST['Nombre'] ); #Vinculacion del parametro Name
        $password = password_hash($_POST['Password'], PASSWORD_BCRYPT); #Codificacion de la Password
        $stmt->bindParam(':Password', $password); #Vinculacion del parametro Password
    }
    if ( $stmt->execute() ){
        $msg = 'Usuario Agregado';
    }
    else{
        $msg = 'Se a producido un error vuelva a intantarlo nuevamente mas tarde';
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
            <input type="text" name="Nombre" placeholder="Ingrese su nombre">
            <input type="password" name="Password" placeholder="Ingrese su contraseña">
            <input type="password" name="Conf_Password" placeholder="Confirme su contraseña">
            <input type="submit" value="Registrar">
        </form>

        <?php if( !empty($msg) ): ?>
            <p> <?php $msg ?> </p>
        <?php endif; ?>

    </body>
</html>