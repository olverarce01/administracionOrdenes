<?php
    include "conexion.php";  

    $prioridad=$_GET['prioridad'];

    if($prioridad==-1){
        $sql = "SELECT ordenes.id as id, ordenes.prioridad as prioridad, categorias.categoria as categoria, fechaCreacion, fechaAsignacion, terminada FROM ordenes, categorias WHERE ordenes.idCategoria=categorias.id";
    }else{
        $sql = "SELECT ordenes.id as id, ordenes.prioridad as prioridad, categorias.categoria as categoria, fechaCreacion, fechaAsignacion, terminada FROM ordenes, categorias WHERE prioridad=".$prioridad." AND ordenes.idCategoria=categorias.id";
    }
    $result = mysqli_query($conn, $sql);  
    $datos = mysqli_fetch_all($result,MYSQLI_ASSOC); 
    echo json_encode($datos);
?>