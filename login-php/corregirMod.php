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
        
        $sql = "UPDATE {$gd} SET tcorrg = :tcorrg, fcorrg = :fcorrg, idusr = :idusr WHERE ncap= :ncap and npag = :npag and nline= :nline";
        $stmt = $conn -> prepare($sql);
        $stmt -> bindParam( ':tcorrg',  $_POST['tcorrg'] );
        $stmt -> bindParam( ':idusr', $_SESSION['user_id']);
        $stmt -> bindParam( ':ncap', $_POST['ncap'] );
        $stmt -> bindParam( ':npag', $_POST['npag'] );
        $stmt -> bindParam( ':nline', $_POST['nline'] ); 
        $stmt -> bindParam( ':fcorrg', $fecha ); 
        $stmt -> execute(); 
        header("Location: modificar.php");

        
    }
/*     if(isset($_POST['siguiente']) ){
        $records = $conn->prepare("SELECT nline FROM gd1 WHERE ncap = :ncap  and npag = :npag ORDER BY nline desc LIMIT 1");
        $records -> bindParam( ':ncap' ,$_POST['ncap']);
        $records -> bindParam(':npag', $_POST['npag']);
        $records->execute();
        $results = $records->fetch();
        $maxline = $results[0];  
        if ($_POST['nline'] < $maxline ){
            $records = $conn->prepare("SELECT id FROM {$_POST['GD']} WHERE ncap = :ncap AND npag = :npag AND nline = :nline");
            $records->bindParam(':ncap', $_POST['ncap']);
            $records->bindParam(':npag', $_POST['npag']);
            $records->bindParam(':nline', $_POST['nline']);
            $records->execute();
            $results = $records->fetch();
            $ncap = $_POST['ncap'];
            $npag = $_POST['npag'];
            $nline = $_POST['nline'];
            $id = $results[0]; 
            $id = $id +1;
            $records = $conn->prepare("SELECT tocr,ncap,npag,nline FROM {$_POST['GD']} WHERE  id = :id");
            $records->bindParam(':id', $id);
            $records->execute();
            $results = $records->fetch();
            //print_r($results);
            $ncap = $results[1]; $_POST['ncap']=$results[1];
            $npag = $results[2];$_POST['npag'] = $results[2];$_POST['nline'] = $results[3];
            $nline = $results[3];
            $tocr = $results[0];
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("No es posible consultar. Se llegó a la ultima linea")';
            echo '</script>';
            }
        
    } */
    if(isset($_POST['anterior']) ){      
        if ($_POST['nline'] > 1 ){
            $records = $conn->prepare("SELECT id FROM {$_POST['GD']} WHERE ncap = :ncap AND npag = :npag AND nline = :nline");
            $records->bindParam(':ncap', $_POST['ncap']);
            $records->bindParam(':npag', $_POST['npag']);
            $records->bindParam(':nline', $_POST['nline']);
            $records->execute();
            $results = $records->fetch();
            $ncap = $_POST['ncap'];
            $npag = $_POST['npag'];
            $nline = $_POST['nline'];
            $id = $results[0]; 
            $id = $id -1;

            $records = $conn->prepare("SELECT tocr,ncap,npag,nline FROM {$_POST['GD']} WHERE  id = :id");
            $records->bindParam(':id', $id);
            $records->execute();
            $results = $records->fetch();
            //print_r($results);
            $ncap = $results[1]; $_POST['ncap']=$results[1];
            $npag = $results[2]; $_POST['npag'] = $results[2];
            $nline = $results[3]; $_POST['nline'] = $results[3];
            $tocr = $results[0];
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("No es posible consultar")';
            echo '</script>';
            }
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

<?
 function separa_nro($gd){
     if (strlen($gd) == 3) echo substr($gd,-1,1);
     else echo substr($gd,-2,2);
    }
 ?>
     <div id = "container">
         <form id = "FORM" method = "POST" action=""> 
         <div id="header"><h1>Revisar Corrección</h1></div>
            <div id="navigation">
            <p><strong>Ubicación</strong></p>
            <label for=''>Guemes Documentado: <?php $res = intval(preg_replace('/[^0-9]+/', '', $gd), 10);  echo $res;  ?> </label>
                <input type="text" name ='GD' id ='GD' readonly='true' style="display:none" value=" <?php  echo $gd; ?> ">
                <br>

                <label for=''>Capítulo: <?php  echo $ncap; ?> </label>
                <input type="text" name ='ncap' id ='ncap' readonly='true' style="display:none" value=" <?php  echo $ncap; ?> ">
                <br>

                <label for=''>Página: <?php  echo  $npag; ?> </label>
                <input type="text" name ='npag' id ='npag' readonly='true'style="display:none"  value="<?php  echo  $npag; ?>">
                <br>

                <label for=''>Número de línea: <?php  echo $nline; ?> </label>
                <input type="text" name ='nline' id ='nline' readonly='true'style="display:none"  value="<?php  echo $nline; ?>">
                <br>

            </div>

            <div id="wrapper">
                <div id="content">
                    <label for=''>Línea original: </label>
                    <div class="input-group">
                        <input class="textline" maxlenght="500"name='tocr' id="tocr" disabled='true' value='<?php  echo $tocr; ?>' />
                        <button type="button" class="btn btn-default btn-sm" onclick="copy()">
                            <span class="glyphicon glyphicon-copy"></span> Copiar
                        </button>
                    </div>
                    <br>

                    <label for=''>Línea sugerida: </label> 
                    <div class="input-group">
                        <input class="textline" name='tsug' id="tsug" disabled='true' value='<?php  echo $tocr; ?>' />
                        <button type="button" class="btn btn-default btn-sm" onclick="copy2()">
                            <span class="glyphicon glyphicon-copy"></span> Copiar
                        </button>
                    </div>
                    <br>

                    <label for=''>Línea a corregir : </label>
                    <input class="textline" name='tcorrg' id="tcorrg" required="true">
                    <br>

                    <input type='submit' name='guardar' id='guardar' value='Guardar y Volver'> 
                    <input type="submit" name="anterior" id="anterior" value="Línea Anterior">
                    <!-- <input type="submit" name="siguiente" id="siguiente" value="Línea Siguiente"> -->
                </div>
            </div>
        </form>
        <br>

        </div>
  </div>


  <div id="footer">
    <p>         
         <a class = b3v href="logout.php"> Salir</a>      
        <a class = b2v href="seleccion.php"> Volver</a>

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
        $(document).ready(function(){
            $("#anterior").click(function(){
                $("#tcorrg").val(" ");
            });
        });

        $(document).ready(function(){
            $("#siguiente").click(function(){
                $("#tcorrg").val(" ");
            });
        });
    </script>
    <script type = "text/javascript">        
        function volver(){
            //alert("Linea guardada" );
            window.location.href = 'modificar.php';            
        }

</script>
    
</body>
</html>


