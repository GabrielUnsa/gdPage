<?php
    require 'database.php';
    $guemes = $_POST['guemes'];
    $records = $conn->prepare("SELECT DISTINCT ncap FROM {$guemes} WHERE idusr IS NULL");
    $records->execute();
    $results = $records->fetchAll();
    $cadena = "<label> Numero de Capitulo </label> <select id='ncap' name='ncap'";
    $cadena = $cadena.'<option value= > </option>';
    foreach ($results as $value) {
        $cadena = $cadena.'<option value='.$value[0].'>'.utf8_encode($value[0]).'</option>';
    }
    echo $cadena."</select>"
?>