<?php
    include "conexion.php";
    if(isset($_GET['id'])) {
        $sql = "DELETE FROM categorias WHERE id=".$_GET['id'];
        mysqli_query($conn, $sql);
    }
    header("Location: ../servicios.php");
?>