<?php
    include "conexion.php";

    if(isset($_GET['dateInicio'])&&isset($_GET['dateFin'])&&isset($_GET['timeInicio'])&&isset($_GET['timeFin'])) {
        $dateInicio = $_GET['dateInicio'];
        $timeInicio = $_GET['timeInicio'];
        $dateTimeInicio= date('Y-m-d H:i:s', strtotime("$dateInicio $timeInicio"));

        $dateFin = $_GET['dateFin'];
        $timeFin = $_GET['timeFin'];
        $dateTimeFin= date('Y-m-d H:i:s', strtotime("$dateFin $timeFin"));
  
        $fechaFiltro = $_GET['fechaFiltro'];

        $sql = "SELECT rs.id,rs.anexo,rs.prioridad,rs.funcionarioContacto,rs.fechaRecepcion,categorias.categoria FROM (SELECT * FROM ordenes WHERE (".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."') AND ordenes.terminada=true) as rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $datos = mysqli_fetch_all($result,MYSQLI_ASSOC); 
        echo json_encode($datos);
        
    }
?>