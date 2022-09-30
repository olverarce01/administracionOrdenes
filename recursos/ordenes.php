<?php
    include "conexion.php";
    $sql = "SELECT categoria, count(*) as contador FROM ordenes GROUP BY categoria";
    if(isset($_GET['dateInicio'])&&isset($_GET['dateFin'])&&isset($_GET['timeInicio'])&&isset($_GET['timeFin'])) {
        $dateInicio = $_GET['dateInicio'];
        $timeInicio = $_GET['timeInicio'];
        $dateTimeInicio= date('Y-m-d H:i:s', strtotime("$dateInicio $timeInicio"));

        $dateFin = $_GET['dateFin'];
        $timeFin = $_GET['timeFin'];
        $dateTimeFin= date('Y-m-d H:i:s', strtotime("$dateFin $timeFin"));
  
        $fechaFiltro = $_GET['fechaFiltro'];



        $sql = "SELECT ro.categoria as categoria, count(*) as contador FROM (SELECT categoria FROM ordenes where ".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."') as ro GROUP BY ro.categoria";
        $result = mysqli_query($conn, $sql);
        $datos = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
   
    }
   
    

    if(!empty($datos)){
        echo json_encode($datos);
    }else{
        echo json_encode([]);
    }
?>