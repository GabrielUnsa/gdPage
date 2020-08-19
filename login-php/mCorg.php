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
    <?php if( !empty( $user ) ): ?>
        <br> Bienvenido!
        <br> <?= $user['nombre'] ?> <?= $user['apellido']?>
        <br> Sigamos trabajando! 
        <br>
    <?php endif;?>
</head>
<body>
<label> Elija un guemes documentado:</label>
        <select id = 'GD' name = "GD">
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
        <label> Numero de Capitulo</label>
        <select id='ncap' name='ncap'> </select>
        <br>
        <label> Numero de Pagina</label>
        <select id='npag' name='npag'> </select>
        <br>
        <label> Numero de Linea</label>
        <select id='nline' name='nline'> </select>
        <br>
        <a href="logout.php"> Salir</a>
</body>
</html>

<script type = "text/javascript">
    $(document).ready(function(){
        recargarLista();
        listpag();
        $('#GD').click(function(){
            recargarLista();
        });
        $('#ncap').click(function(){
            listpag();
        });
        $('#npag').click(function () {
            listline();
        });
    })
</script>

<script type = "text/javascript">
    function recargarLista(){
        $.ajax({
            type: "POST",
            url: "cargaCap.php",
            data: "guemes=" + $('#GD').val(),
            success:function(r){
                $('#ncap').html(r)
            }
        });
    }
</script>

<script type = "text/javascript">
    function listpag(){
        $.ajax({
            type: "POST",
            url: "cargaPag.php",
            data: { "guemes": $('#GD').val(), "cap": $('#ncap').val()},
            success:function(r){
                $('#npag').html(r)
            }
        });
    }
</script>

<script type = "text/javascript">
    function listline(){
        $.ajax({
            type: "POST",
            url: "cargaLine.php",
            data: { "guemes": $('#GD').val(), "cap": $('#ncap').val(), "pag":$('#npag').val()},
            success:function(p){
                $('#nline').html(p)
            }
        });
    }
</script>