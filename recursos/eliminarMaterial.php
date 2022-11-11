<?php
    include "conexion.php";
    if(isset($_GET['id'])) {
        $sql = "DELETE FROM materiales WHERE id=".$_GET['id'];
        mysqli_query($conn, $sql);
    }
    header("Location: ../materiales.php");
?>