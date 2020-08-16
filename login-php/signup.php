<?php
    require 'database.php';

    $msg = '';
    if( !empty( $_POST['nombre'] ) && !empty( $_POST['apellido'] )
        !empty( $_POST['nickname'] ) && !empty( $_POST['password'] ) &&
        !empty( $_POST['conf_password'] ) ){
            if( $_POST['password'] == $_POST['conf_password'] ){
                try{
                    $full_name = $_POST['nombre'];
                    $last_name = $_POST['apellido'];
                    $nickname = $_POST['nickaname'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $sql = "INSERT INTO users (nombre, apellido, nickname, password) VALUES (:nombre, :apellido, :nickname, :password)";
                    $stmt = $pdoConnect -> prepare($sql);
                    $stmt -> bindParam( ':nombre', $nombre, PDO::PARAM_STR );
                    $stmt -> bindParam( ':apellido', $apellido, PDO::PARAM_STR );
                    $stmt -> bindParam( ':nickname', $nickname, PDO::PARAM_STR );
                    $stmt -> bindParam( ':password', $password, PDO::PARAM_STR );
                    $pdoExec = $stmt -> execute();
                }catch(PDOException $e){
                    print 'ERROR: '.$e->getMessage();
                    print '<br/>Data Not Inserted';
                }
                if($pdoExec)
                {
                    echo 'Data Inserted';
                }
                /*$query = mysql_query("SELECT * FROM users WHERE username=’".$ncikname."’");
                $numrows = mysql_num_rows($query);
                if( $numrows == 0 ){
                    $sql = " INSERT INTO users ( nombre, apellido, nickname, password ) VALUES ( '$full_name' ,'$last_name' ,'$nickname' ,'$password' ) ";
                    $result = mysql_query($sql);
                    $result = mysql($sql);
                    if( $result ){
                        $msg = "Cuenta creada";
                    }else{
                        $msg = "Error INSERT";
                    }
                } else{
                    $msg = 'Usuario ya existente!';
                }*/
                /*$sql = "INSERT INTO users ( nombre, apellido, nickname, password ) VALUES ( :nombre, :apellido, :nickname, :password )";
                $stmt = $conn->prepare( $sql ); #Consulta sql
                $stmt->bindParam( ':nombre', $_POST['nombre'] ); #Vinculacion del parametro Name
                $stmt->bindParam( ':apellido', $_POST['apellido'] );
                $stmt->bindParam( ':nickname', $_POST['nickname'] );
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT); #Codificacion de la Password
                $stmt->bindParam(':password', $password); #Vinculacion del parametro Password*/
            }else{
                $msg = 'No coinciden las contraseñas ingresadas';
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
        <span> o <a href="login.php"> Identificarse </a></span>
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
