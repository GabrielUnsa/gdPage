<?php
    require 'database.php';
    $guemes = $_POST['guemes'];
    $records = $conn->prepare("SELECT DISTINCT ncap FROM {$guemes} WHERE idusr IS NOT NULL");
    $records->execute();
    $results = $records->fetchAll();
    foreach ($results as $value) {
        $cadena = $cadena.'<option value='.$value[0].'>'.utf8_encode($value[0]).'</option>';
    }
    echo $cadena;
?>