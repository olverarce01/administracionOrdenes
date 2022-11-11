<?php
    include "conexion.php";
    if(isset($_GET['modo'])) {
      
        if($_GET['modo']=='eliminar' &&isset($_GET['id'])){


            $sql = "DELETE FROM categorias WHERE id=".$_GET['id'];
            mysqli_query($conn, $sql);

        }
        if($_GET['modo']=='agregar' &&isset($_GET['nombre'])){
            
            $categoria=$_GET['nombre'];

            $stmt = mysqli_prepare($conn,"INSERT INTO categorias (categoria) VALUES (?)");
            mysqli_stmt_bind_param($stmt, 's', $categoria);            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
   
    $sql = "SELECT * FROM categorias";
    $result = mysqli_query($conn, $sql);
    $datos = mysqli_fetch_all($result,MYSQLI_ASSOC);

    if(!empty($datos)){
        echo json_encode($datos);
    }else{
        echo json_encode([]);
    }
?>