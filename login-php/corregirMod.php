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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
 -->
    <title>Correcion GD</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body> 
    <?php require 'partials/header.php' ?>
    

        
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
        header("Location: modificar.php");
/*         $records = $conn->prepare("SELECT ncap, npag, nline FROM {$gd} WHERE idusr IS NULL LIMIT 1");
        $records->execute();
        $results = $records->fetch();
        $_POST['ncap'] = $results['ncap'];
        $_POST['npag'] = $results['npag'];
        $_POST['nline'] = $results['nline']; */
        
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
        
     <div id = "container">
         <form id = "FORM" method = "POST" action=""> 
         <div id="header"><h1>Revisar Corrección</h1></div>
            <div id="navigation">
            <p><strong>Ubicación</strong></p>
            <label for=''>Guemes Documentado: <?php  echo substr($_POST['GD'],-1,1); ?> </label>  
                <br>

            <label for=''>Capítulo: <?php  echo $ncap; ?> </label>  
            <br>

            <label for=''>Página: <?php  echo  $npag; ?> </label>
            <br>

            <label for=''>Número de línea: <?php  echo $nline; ?> </label>
            <br>
            </div>

        <div id="wrapper">
            <div id="content">
            <label for=''>Línea original: </label> 
        <div vlass="input-group">
        <input class="textline"  maxname='tocr' id="tocr" disabled ='true' value= '<?php  echo $tocr; ?>' />
        <div class="input-group-append">
        <button type="button" class="btn btn-default btn-sm" onclick="copy()">
            <span class="glyphicon glyphicon-copy"></span> Copiar 
        </button>
        </div>
        </div>

        <!-- <input class = "copiar" maxlenght="500" type="button" id="copiarTocr" value="Copiar para editar" onclick="copy()" /> -->
        <br>
        
        <label for=''>Línea sugerida: </label> <br>
        <input class="textline" maxlenght="500" name='tsug' id="tsug" disabled ='true' value='<?php  echo $tocr; ?>' />
        <button type="button" class="btn btn-default btn-sm" onclick="copy2()">
            <span class="glyphicon glyphicon-copy"></span> Copiar 
        </button>
        <!-- <input class = "copiar" type="button" id="copiarTsug" value="Copiar para editar" onclick="copy2()" /> -->
        <br>

        <label for=''>Línea a corregir : </label>
        <input class="textline" name='tcorrg' id="tcorrg" required = "true" >

            <br>
            <input type='submit' name='guardar' id='guardar' value='Guardar'>
         </form>
        <br>

        </div>
  </div>


  <div id="footer">
    <p>        
        <a class = b2v href="seleccion.php"> Volver</a>
        <a class = b3v href="logout.php"> Salir</a>
        <br></p>
  </div>
</div>
     </div>   


    
    <script type="text/javascript">
        function copy() {
            $("#tcorrg").val(document.getElementById("tocr").value);
        }
        function copy2() {
            $("#tcorrg").val(document.getElementById("tsug").value); 
        }
    </script>
    <script type = "text/javascript">        
        function volver(){
            //alert("Linea guardada" );
            window.location.href = 'modificar.php';            
        }

</script>
    
</body>
</html>


