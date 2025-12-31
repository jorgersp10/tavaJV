<?php
//Parametros de Coneccion
    $host="localhost";
    $user="root";
    $password="";
    $database="inmo_db";
    
    $mysqli = new mysqli($host, $user, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Fallo la conexion a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    
    $stmt = $mysqli ->prepare("CALL sp_update_mora();");
    $stmt->execute();
    $stmt->close();
    $mysqli->close();



?>