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
                echo "<h5 class='text-white font-weight-bold'>".$row["contador"]."  <span class='text-warning font-weight-light'> Terminadas</span></h5>";
                

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
                echo "<h5 class='text-white font-weight-bold'>".$row["contador"]."  <span class='text-warning font-weight-light'> Pendientes</span></h5>";
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
                echo "<h5 class='text-white font-weight-bold'>".$row["contador"]."  <span class='text-warning font-weight-light'> Urgentes</span></h5>";
            }
        } else {
            echo "0 resultados";
        }
    }



    function obtenerDataGraficoFrecuenciaVSTipoOrden(){
        include "conexion.php";  
        $colores= array("#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D");
           $sql = "SELECT categorias.categoria, rs.contador as contador FROM (SELECT idCategoria, count(*) as contador FROM (SELECT * FROM ordenes WHERE terminada=1 AND fechaCreacion BETWEEN '".date('Y-m-d', strtotime("- 1 month"))."' AND '".date('Y-m-d')."') as w GROUP BY w.idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
           $result = mysqli_query($conn, $sql);
           $labels_frecuenciaCategorias =[];
           $cantidades_frecuenciaCategorias= [];
           $colores_frecuenciaCategorias= [];
   
           if (mysqli_num_rows($result) > 0) {
   
               while($row = mysqli_fetch_assoc($result)) {
                 array_push($labels_frecuenciaCategorias, "".$row["categoria"]."");
                 array_push($cantidades_frecuenciaCategorias, "".$row["contador"]."");
                 
                 
                 $index= mt_rand(0, sizeof($colores)-1);
                 array_push($colores_frecuenciaCategorias, $colores[$index]);
   
               }
                return array($labels_frecuenciaCategorias, $cantidades_frecuenciaCategorias,$colores_frecuenciaCategorias);
            }
        return null;
    }
    function obtenerDataGraficoCostoMaterialesVSTipoTrabajo(){
        include "conexion.php";  
        $colores= array("#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D");
        $sql = "SELECT categorias.categoria, rs.precioMateriales as precioMateriales FROM (SELECT idCategoria, sum(precioMateriales) as precioMateriales FROM (SELECT * FROM ordenes WHERE terminada=1 AND fechaCreacion BETWEEN '".date('Y-m-d', strtotime("- 1 month"))."' AND '".date('Y-m-d')."') as w GROUP BY w.idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoMaterialesCategorias =[];
        $cantidades_costoMaterialesCategorias= [];
        $colores_costoMaterialesCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoMaterialesCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoMaterialesCategorias, "".$row["precioMateriales"]."");
              
              $index= mt_rand(0, sizeof($colores)-1);
              array_push($colores_costoMaterialesCategorias, $colores[$index]);

              
            }
            return array($labels_costoMaterialesCategorias, $cantidades_costoMaterialesCategorias,$colores_costoMaterialesCategorias);
        }
    return null;
    }
    function obtenerDataGraficoCostoFuncionariosEjecutivosVSTipoTrabajo(){
        include "conexion.php";  
        $colores= array("#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D");
        $sql = "SELECT categorias.categoria, precioFuncionariosEjecutores FROM (SELECT idCategoria, sum(precioFuncionariosEjecutores*horasHombre) as precioFuncionariosEjecutores FROM (SELECT * FROM ordenes WHERE terminada=1 AND fechaCreacion BETWEEN '".date('Y-m-d', strtotime("- 1 month"))."' AND '".date('Y-m-d')."') as w GROUP BY w.idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoFuncionariosEjecutivosCategorias =[];
        $cantidades_costoFuncionariosEjecutivosCategorias= [];
        $colores_costoFuncionariosEjecutivosCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoFuncionariosEjecutivosCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoFuncionariosEjecutivosCategorias, "".$row["precioFuncionariosEjecutores"]."");
              

              $index= mt_rand(0, sizeof($colores)-1);
              array_push($colores_costoFuncionariosEjecutivosCategorias, $colores[$index]);

            }
            return array($labels_costoFuncionariosEjecutivosCategorias, $cantidades_costoFuncionariosEjecutivosCategorias,$colores_costoFuncionariosEjecutivosCategorias);
        }
    return null;
    }
    function obtenerDataGraficoCostoTotalVSTipoTrabajo(){
        include "conexion.php";  
        $colores= array("#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D");
        $sql = "SELECT categorias.categoria, costosTotal FROM (SELECT idCategoria, sum(costoTotal) as costosTotal FROM (SELECT * FROM ordenes WHERE terminada=1 AND fechaCreacion BETWEEN '".date('Y-m-d', strtotime("- 1 month"))."' AND '".date('Y-m-d')."') as w GROUP BY w.idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoTotalCategorias =[];
        $cantidades_costoTotalCategorias= [];
        $colores_costoTotalCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoTotalCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoTotalCategorias, "".$row["costosTotal"]."");
              
              $index= mt_rand(0, sizeof($colores)-1);
              array_push($colores_costoTotalCategorias, $colores[$index]);

            }
            return array($labels_costoTotalCategorias, $cantidades_costoTotalCategorias,$colores_costoTotalCategorias);
        } 
    return null;
    }
    function obtenerDataGraficoFrecuenciaVSOrdenesPorHoras(){
        include "conexion.php";  
        $colores= array("#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D");
        $sql = "SELECT horasHombre, count(*) as frecuenciaHoras FROM (SELECT * FROM ordenes WHERE terminada=1 AND fechaCreacion BETWEEN '".date('Y-m-d', strtotime("- 1 month"))."' AND '".date('Y-m-d')."') as w GROUP BY w.horasHombre";
        $result = mysqli_query($conn, $sql);
        $labels_frecuenciaOrdenesPorHoras =[];
        $cantidades_frecuenciaOrdenesPorHoras= [];
        $colores_frecuenciaOrdenesPorHoras= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_frecuenciaOrdenesPorHoras, "".$row["horasHombre"]."");
              array_push($cantidades_frecuenciaOrdenesPorHoras, "".$row["frecuenciaHoras"]."");
           
              $index= mt_rand(0, sizeof($colores)-1);
              array_push($colores_frecuenciaOrdenesPorHoras, $colores[$index]);

           
            }
            return array($labels_frecuenciaOrdenesPorHoras, $cantidades_frecuenciaOrdenesPorHoras,$colores_frecuenciaOrdenesPorHoras);   
        }
    return null;
    }
?>
