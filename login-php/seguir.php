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
</head>
<body>
<p class = 'letsgo'> Sigamos! </p>
<form action='corregir.php' method='POST'>
    <label class = 'labels'> Elija un guemes documentado:</label>
            <select class = 'selects' id = 'GD' name = "GD" >
                <option value = gd1> 1 </option>
                <option value = gd2> 2 </option>
                <option value = gd3> 3 </option>
                <option value = gd4> 4 </option>
                <option value = gd5> 5 </option>
                <option value = gd6> 6 </option>
                <option value = gd7> 7 </option>
                <option value = gd8> 8 </option>
                <option value = gd9> 9 </option>
                <option value = gd10> 10 </option>
                <option value = gd11> 11 </option>
                <option value = gd12> 12 </option>
            </select>
            <br>
    <div id = "list"> </div>
    <br>
    <input  href = 'corregir.php' type = 'submit' value = Siguiente >    
</form>
    <br>
    <br>
    <a class = 'b3v' href = 'logout.php'> Salir </a>
    <a class = 'b2v' href = 'seleccion.php'> Volver </a>
</body>
</html>

<script type = "text/javascript">
    $(document).ready(function(){
        recargarLista();
        $('#GD').click(function(){
            recargarLista();
        });
    });
</script>

<script type = "text/javascript">
    function recargarLista(){
        $.ajax({
            type: "POST",
            url: "carga/loadAll.php",
            data: "guemes=" + $('#GD').val(),
            success:function(r){
                $('#list').html(r)
            }
        });
    }
</script>
