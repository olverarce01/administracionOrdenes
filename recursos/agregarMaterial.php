<?php
    include "conexion.php";
    if(isset($_POST['nombre'])) {
        $nombre=$_POST['nombre'];
        $precioUnitario=$_POST['precioUnitario'];
        
        $stmt = mysqli_prepare($conn,"INSERT INTO materiales (nombre, precioUnitario) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt, 'si', $nombre,$precioUnitario);            
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: ../materiales.php");


    /* if(!empty($datos)){
        echo json_encode($datos);
    }else{
        echo json_encode([]);
    } */
?>