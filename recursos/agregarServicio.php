<?php
    include "conexion.php";
    if(isset($_POST['nombre'])) {
        $nombre=$_POST['nombre'];
        $nombre = strtoupper($nombre);

        
        $stmt = mysqli_prepare($conn,"INSERT INTO categorias (categoria) VALUES (?)");
        mysqli_stmt_bind_param($stmt, 's', $nombre);           
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: ../servicios.php");


    /* if(!empty($datos)){
        echo json_encode($datos);
    }else{
        echo json_encode([]);
    } */
?>