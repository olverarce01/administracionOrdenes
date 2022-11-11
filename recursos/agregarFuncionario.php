<?php
    include "conexion.php";
    if(isset($_POST['rut'])) {
        $rut=$_POST['nombre'];
        $nombre=$_POST['rut'];
        $cargo=$_POST['cargo'];
        $precioHora=$_POST['precioHora'];
        
        $stmt = mysqli_prepare($conn,"INSERT INTO funcionarios (rut, nombre, cargo, precioHora) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sssi', $rut,$nombre,$cargo,$precioHora);            
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: ../funcionarios.php");


    /* if(!empty($datos)){
        echo json_encode($datos);
    }else{
        echo json_encode([]);
    } */
?>