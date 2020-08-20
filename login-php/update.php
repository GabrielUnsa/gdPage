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
    //update gd1 set tocr=' PAPELES QUE A LA MUERTE DE GÜEMES', tcorrg='hola' 
    //where ncap=1 and npag = 11 and nlinea=1  fcorrg= 'SELECT CURRENT_TIMESTAMP();',
    // if( isset($_POST['siguiente']) ){
        //
/*         $ncap = $_POST['ncap'];
        $npag = $_POST['npag'];
        $nlinea = $_POST['nlinea']; 
        $tcorrg = $_POST['tcorrg']; */ 
/*         $npag = 11;
        $nlinea = 1; */
        print_r($_POST);
            if( !empty($tcorrg) ){
                
                $sql = "UPDATE gd1 SET tcorrg = :tcorrg,  idusr = :idusr WHERE ncap= :ncap and npag = :npag and nlinea= :nlinea";
                $stmt = $conn -> prepare($sql);
                $stmt -> bindParam( ':tcorrg',  $_POST['tcorrg'] );
                $stmt -> bindParam( ':idusr', $_SESSION['user_id']);
                $stmt -> bindParam( ':ncap', $_POST['ncap'] );
                $stmt -> bindParam( ':npag', $_POST['npag'] );
                $stmt -> bindParam( ':nlinea', $_POST['nlinea'] ); 
        
                $stmt -> execute(); 
                $results = $stmt->fetch();
                $msg = 'update';
                echo $msg;
                print_r($_POST);
                echo($results);

            }
                                   
    //} 
?>