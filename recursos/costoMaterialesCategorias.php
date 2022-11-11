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

        $sql = "SELECT rss.categoria as categoria, sum(rss.precioMateriales) as precioMateriales FROM (SELECT categorias.categoria as categoria, precioMateriales FROM (SELECT * FROM ordenes WHERE (".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."') AND terminada=1) as rs, categorias WHERE rs.idCategoria=categorias.id) as rss GROUP BY rss.categoria";
        $result = mysqli_query($conn, $sql);
        $datos = mysqli_fetch_all($result,MYSQLI_ASSOC); 
        echo json_encode($datos);
        
    }
?>