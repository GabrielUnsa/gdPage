<?php
    require 'database.php';
    $guemes = $_POST['guemes'];
     $records = $conn->prepare("SELECT ncap, npag, nline FROM {$guemes} WHERE idusr IS NULL LIMIT 1");
    $records->execute();
    $results = $records->fetch();
    $cadena = "<label> Numero de Capitulo </label>
                <select id = 'ncap' name = 'ncap' disabled >";
    $cadena = $cadena.'<option value='.$results[0].'>'.utf8_encode($results[0]).'</option>';
    $cadena = $cadena."</select> <br>";
    $cadena = $cadena."<label> Numero de Pagina </label>
                <select id = 'npag' name = 'npag' disabled >";
    $cadena = $cadena.'<option value='.$results[1].'>'.utf8_encode($results[1]).'</option>';
    $cadena = $cadena."</select> <br>";
    $cadena = $cadena."<label> Numero de Linea </label>
                <select id = 'nline' name = 'nline' disabled >";
    $cadena = $cadena.'<option value='.$results[2].'>'.utf8_encode($results[2]).'</option>';
    echo $cadena."</select> <br>";
?>