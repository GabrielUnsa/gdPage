<?php 
$server = 'localhost:8080';
$username = 'root';
$password = '0000';
$database = 'db_php_name';

try {
    $conn = new PDO( "mysql:hots=$server; dbname=$database; $username; $password" );
} catch ( PDOException $e ) {
    die( 'Conexion fallida: '. $e->getMessage() );
}

?>