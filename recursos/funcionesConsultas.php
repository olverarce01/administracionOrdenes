<?php
    function obtenerTotalCosto(){
        include "conexion.php";  
        $sql = "SELECT sum(costoTotal) as total FROM ordenes";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<h5 class='text-warning'>$".$row["total"]." <span class='text-white font-weight-light'>Ordenes<span></h5>";
            }
        } else {
            echo "0 resultados";
        }
    } 
    function obtenerTotalMateriales(){
        include "conexion.php";  
        $sql = "SELECT sum(precioMateriales) as total FROM ordenes";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              echo "<h5 class='text-warning'>$".$row["total"]." <span class='text-white font-weight-light'>Materiales<span></h5>";
            }
        } else {
            echo "0 resultados";
        }
    }
    function obtenerTotalFuncionarios(){
        include "conexion.php";  
        $sql = "SELECT sum(precioFuncionariosEjecutores*horasHombre) as total FROM ordenes";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h5 class='text-warning'>$".$row["total"]." <span class='text-white font-weight-light'>Mano de Obra<span></h5>";
            }
        } else {
            echo "0 resultados";
        }    
    }
    function obtenerCantidadOrdenesTerminadas(){
        include "conexion.php";  
        $sql = "SELECT count(*) as contador FROM ordenes WHERE terminada=1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h3> <span class='text-success badge badge-light'>".$row["contador"]." Terminadas</span></h3>";
            }
        } else {
            echo "0 resultados";
        }
    }
    function obtenerCantidadOrdenesNoTerminadas(){
        include "conexion.php";  
        $sql = "SELECT count(*) as contador FROM ordenes WHERE terminada=0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h3> <span class='text-warning badge badge-light'>".$row["contador"]." Pendientes</span></h3>";
            }
        } else {
            echo "0 resultados";
        }
    }
    function obtenerCantidadOrdenesAltaPrioridad(){
        include "conexion.php";  
        $sql = "SELECT count(*) as contador FROM ordenes WHERE prioridad=0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h3> <span class='text-danger badge badge-light'>".$row["contador"]." Urgentes</span></h3>";
            }
        } else {
            echo "0 resultados";
        }
    }
    function obtenerDataGraficoFrecuenciaVSTipoOrden(){
        include "conexion.php";  
           $sql = "SELECT categorias.categoria, rs.contador as contador FROM (SELECT idCategoria, count(*) as contador FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
           $result = mysqli_query($conn, $sql);
           $labels_frecuenciaCategorias =[];
           $cantidades_frecuenciaCategorias= [];
           $colores_frecuenciaCategorias= [];
   
           if (mysqli_num_rows($result) > 0) {
   
               while($row = mysqli_fetch_assoc($result)) {
                 array_push($labels_frecuenciaCategorias, "".$row["categoria"]."");
                 array_push($cantidades_frecuenciaCategorias, "".$row["contador"]."");
                 
                 $rgbColor= array();
                 foreach(array('r', 'g', 'b') as $color){
                   $rgbColor[$color] = mt_rand(0, 255);
                 }
                 array_push($colores_frecuenciaCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].", 0.7)");
   
               }
                return array($labels_frecuenciaCategorias, $cantidades_frecuenciaCategorias,$colores_frecuenciaCategorias);
            }
        return null;
    }
    function obtenerDataGraficoCostoMaterialesVSTipoTrabajo(){
        include "conexion.php";  
        $sql = "SELECT categorias.categoria, rs.precioMateriales as precioMateriales FROM (SELECT idCategoria, sum(precioMateriales) as precioMateriales FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoMaterialesCategorias =[];
        $cantidades_costoMaterialesCategorias= [];
        $colores_costoMaterialesCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoMaterialesCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoMaterialesCategorias, "".$row["precioMateriales"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoMaterialesCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
            return array($labels_costoMaterialesCategorias, $cantidades_costoMaterialesCategorias,$colores_costoMaterialesCategorias);
        }
    return null;
    }
    function obtenerDataGraficoCostoFuncionariosEjecutivosVSTipoTrabajo(){
        include "conexion.php";  
        $sql = "SELECT categorias.categoria, precioFuncionariosEjecutores FROM (SELECT idCategoria, sum(precioFuncionariosEjecutores*horasHombre) as precioFuncionariosEjecutores FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoFuncionariosEjecutivosCategorias =[];
        $cantidades_costoFuncionariosEjecutivosCategorias= [];
        $colores_costoFuncionariosEjecutivosCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoFuncionariosEjecutivosCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoFuncionariosEjecutivosCategorias, "".$row["precioFuncionariosEjecutores"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoFuncionariosEjecutivosCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
            return array($labels_costoFuncionariosEjecutivosCategorias, $cantidades_costoFuncionariosEjecutivosCategorias,$colores_costoFuncionariosEjecutivosCategorias);
        }
    return null;
    }
    function obtenerDataGraficoCostoTotalVSTipoTrabajo(){
        include "conexion.php";  
        $sql = "SELECT categorias.categoria, costosTotal FROM (SELECT idCategoria, sum(costoTotal) as costosTotal FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoTotalCategorias =[];
        $cantidades_costoTotalCategorias= [];
        $colores_costoTotalCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoTotalCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoTotalCategorias, "".$row["costosTotal"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoTotalCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
            return array($labels_costoTotalCategorias, $cantidades_costoTotalCategorias,$colores_costoTotalCategorias);
        } 
    return null;
    }
    function obtenerDataGraficoFrecuenciaVSOrdenesPorHoras(){
        include "conexion.php";  
        $sql = "SELECT horasHombre, count(*) as frecuenciaHoras FROM ordenes GROUP BY horasHombre";
        $result = mysqli_query($conn, $sql);
        $labels_frecuenciaOrdenesPorHoras =[];
        $cantidades_frecuenciaOrdenesPorHoras= [];
        $colores_frecuenciaOrdenesPorHoras= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_frecuenciaOrdenesPorHoras, "".$row["horasHombre"]."");
              array_push($cantidades_frecuenciaOrdenesPorHoras, "".$row["frecuenciaHoras"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_frecuenciaOrdenesPorHoras, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
            return array($labels_frecuenciaOrdenesPorHoras, $cantidades_frecuenciaOrdenesPorHoras,$colores_frecuenciaOrdenesPorHoras);   
        }
    return null;
    }
?>
