<?php
    require 'database.php';

    $records = $conn->prepare('SELECT * FROM gd1 WHERE idusr IS NULL');
    $records->execute();
    $results = $records->fetch();
    
?>