<?php
    include "./conexion.php";
    if(isset($_GET['Terminar'])){
        $id= $_GET['ver'];
        $sql = "UPDATE ordenes SET terminada= NOT terminada  WHERE id=".$id."";
        if (mysqli_query($conn, $sql)) {
        } else {
          echo "Error al Terminar: " . mysqli_error($conn);
        }
    }
    header("Location: ./verOrden.php?ver=".$id);
?>