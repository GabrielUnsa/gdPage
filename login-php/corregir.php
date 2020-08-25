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
    
        <div>
        <h1>Revisar Corrección</h1>
    <?php 
    $gd = $_POST['GD'];

    if(isset($_POST['guardar']) ){
        date_default_timezone_set("America/Argentina/Salta");
        $fecha = date('Y-m-d H:i:s', time());
        
        $sql = "UPDATE gd1 SET tcorrg = :tcorrg, fcorrg = :fcorrg, idusr = :idusr WHERE ncap= :ncap and npag = :npag and nline= :nline";
        $stmt = $conn -> prepare($sql);
        $stmt -> bindParam( ':tcorrg',  $_POST['tcorrg'] );
        $stmt -> bindParam( ':idusr', $_SESSION['user_id']);
        $stmt -> bindParam( ':ncap', $_POST['ncap'] );
        $stmt -> bindParam( ':npag', $_POST['npag'] );
        $stmt -> bindParam( ':nline', $_POST['nline'] ); 
        $stmt -> bindParam( ':fcorrg', $fecha ); 
        $stmt -> execute(); 
        $records = $conn->prepare("SELECT ncap, npag, nline FROM {$gd} WHERE idusr IS NULL LIMIT 1");
        $records->execute();
        $results = $records->fetch();
        $_POST['ncap'] = $results['ncap'];
        $_POST['npag'] = $results['npag'];
        $_POST['nline'] = $results['nline'];
  
    }


/*         if (is_null($_POST['GD'])){
            echo $_POST['GD'];
        } */

        $records = $conn->prepare("SELECT tocr FROM {$_POST['GD']} WHERE ncap = :ncap AND npag = :npag AND nline = :nline");
        $records->bindParam(':ncap', $_POST['ncap']);
        $records->bindParam(':npag', $_POST['npag']);
        $records->bindParam(':nline', $_POST['nline']);
        $records->execute();
        $results = $records->fetch();
        $ncap = $_POST['ncap'];
        $npag = $_POST['npag'];
        $nline = $_POST['nline'];
        $tocr = $results[0]; 
        //print_r($_POST); 
        ?>
        
        
        <form id = "FORM" method = "POST" action=""> 
            <label for=''>Guemes Documentado: </label>  
            <input type="text" name ='GD' id ='GD' readonly='true' value=" <?php  echo $_POST['GD']; ?> ">
            <br>

            <label for=''>Capítulo: </label>  
            <input type="text" name ='ncap' id ='ncap' readonly='true' value=" <?php  echo $ncap; ?> ">
            <br>

            <label for=''>Página: </label>
            <input type="text" name ='npag' id ='npag' readonly='true' value="<?php  echo  $npag; ?>">
            <br>

            <label for=''>Número de línea: </label>
            <input type="text" name ='nline' id ='nline' readonly='true' value="<?php  echo $nline; ?>">
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
            <p><textarea name='tcorrg' id="tcorrg" required = "true" ></textarea></p>
            

            <br>
            <input type='submit' name='guardar' id='guardar' value='Guardar'>
         </form>
        <br>
        <a class = b2v href="seleccion.php"> Volver</a>
        <a class = b3v href="logout.php"> Salir</a>
        <br>
    
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


