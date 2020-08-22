<?php
    session_start();
    require 'database.php';
    if( !empty( $_POST['tcorrg'] ) ){
        $sql = "UPDATE gd1 SET tcorrg = :tcorrg,  idusr = :idusr WHERE ncap= :ncap and npag = :npag and nline= :nlinea";
        $stmt = $conn -> prepare($sql);
        $stmt -> bindParam( ':tcorrg',  $_POST['tcorrg'] );
        $stmt -> bindParam( ':idusr', $_SESSION['user_id']);
        $stmt -> bindParam( ':ncap', $_POST['ncap'] );
        $stmt -> bindParam( ':npag', $_POST['npag'] );
        $stmt -> bindParam( ':nlinea', $_POST['nlinea'] ); 
        $stmt -> execute(); 
    }                   
?>
<script type = "text/javascript">
            alert("Linea guardada");
            window.location.href = 'corregir.php';
</script>