<?php
    require 'database.php';

    $msg = '';
    if( !empty( $_POST['nombre'] ) && !empty( $_POST['apellido'] ) &&
        !empty( $_POST['nickname'] ) && !empty( $_POST['password'] ) &&
        !empty( $_POST['conf_password'] ) ){
            $sql = "SELECT COUNT(nickname) FROM users WHERE nickname = :nickname";
            $stmt = $conn -> prepare($sql);
            $stmt->bindParam( ':nickname', $_POST['nickname'] );
            $stmt -> execute();
            $row = $stmt -> fetchColumn();
            if( $row > 0 ){
                $msg = 'Existe un usuario con ese nickname';
            }else{
                if( $_POST['password'] == $_POST['conf_password'] ){
                    try{
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $sql = "INSERT INTO users (nombre, apellido, nickname, password) VALUES (:nombre, :apellido, :nickname, :password)";
                        $stmt = $conn -> prepare($sql);
                        $stmt -> bindParam( ':nombre',  $_POST['nombre'] );
                        $stmt -> bindParam( ':apellido', $_POST['apellido'] );
                        $stmt -> bindParam( ':nickname', $_POST['nickname'] );
                        $stmt -> bindParam( ':password', $password );
                        if ( $stmt -> execute() ){
                            $msg = 'Nuevo usuario Agregado';
                        }else{
                            $msg = 'No se pudo agregar su usuario, por favor intente mas tarde';
                        }
                    }catch(PDOException $e){
                        print 'ERROR: '.$e->getMessage();
                        print '<br/> Error intente mas tarde';
                    }
                }else{
                    $msg = 'No coinciden las contraseñas ingresadas';
                }
            }
    }else{
        $msg = 'Debe completar todos los campos';
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
        <span> o <a href="index.php"> Identificarse </a></span>
        <?php if ( !empty( $msg ) ) { echo "<p class=\"error\">" . "Mensaje: ". $msg . "</p>"; } ?>
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
