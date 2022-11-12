<?php
ob_start();
    include "./funcionesLogin.php";
    include "./funcionesConsultas.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    libreriasCDN();
    ?>
    <title>OrdenesTrabajo</title>
    <!-- <style>
        th, td {
        border: 1px solid black;
        }
    </style> -->
</head>
<body>
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
  <p class="text-center h1 font-weight-bold">Ordenes de trabajo</p>
  
  <?php if (isset($_GET['dateInicio'])&&isset($_GET['dateFin'])&&isset($_GET['timeInicio'])&&isset($_GET['timeFin'])): ?>

  <span>
    Filtro: 
    <?php
      echo $_GET['fechaFiltro'];
    ?>
  </span>
  <span>
    Fechas: 
    <?php
      echo $_GET['dateInicio'].' '.$_GET['timeInicio'].' | '.$_GET['dateFin'].' '.$_GET['timeFin'];
    ?>
  </span>
  <?php endif ?>


<table class="table table-hover">
  <thead>
    <tr>
      <th>NºOrden</th>
        <th scope="col">FechaAsignacion</th>
        <th scope="col">Prioridad</th>
        <th scope="col">Co. Materiales</th>
        <th scope="col">Co. Funcionarios</th>
        <th scope="col">Co. Total</th>
    </tr>
  </thead>
  <tbody>
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

        $sql = "SELECT CONVERT( rs.fechaAsignacion,DATE) as dateAsignacion,rs.*,categorias.categoria FROM (SELECT * FROM ordenes WHERE (".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."') AND ordenes.terminada=true) as rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        //$datos = mysqli_fetch_all($result,MYSQLI_ASSOC); 
        //echo json_encode($datos);
        
    }else{
        $sql = "SELECT ordenes.*, categorias.categoria FROM ordenes as rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
    }
    if (mysqli_num_rows($result) > 0) {

        $costoFuncionarios=0;
        $costoTotal=0;
        $costoMateriales=0;
        while($row = mysqli_fetch_assoc($result)) {
            $costoTotal=$costoTotal + $row['costoTotal'];
            $costoFuncionarios=$costoFuncionarios + $row['precioFuncionariosEjecutores']*$row['horasHombre'];
            $costoMateriales =$costoMateriales + $row['precioMateriales'];
            echo "<tr>";
            echo "<th scope='row'>".$row['id']."</th>";
            echo "<td>".$row['dateAsignacion']."</td>";
            if($row['prioridad']==0){
              echo "<td><span class='badge badge-danger'>Alta</span></td>";
            }elseif ($row['prioridad']==1){
              echo "<td><span class='badge badge-warning'>Media Alta</span></td>";
            }
            elseif ($row['prioridad']==2){
              echo "<td><span class='badge badge-primary'>Media</span></td>";
            }elseif ($row['prioridad']==3){
              echo "<td><span class='badge badge-info'>Media Baja</span></td>";
            }elseif ($row['prioridad']==4){
              echo "<td><span class='badge badge-success'>Baja</span></td>";
            }
            
            
            
            echo "<td>$".$row['precioMateriales']."</td>";
            echo "<td>$".$row['precioFuncionariosEjecutores']*$row['horasHombre']."</td>";
            echo "<td>$".$row['costoTotal']."</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<th scope='row'>Totales</th>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td>Total: $".$costoMateriales."</td>";
        echo "<td>Total: $".$costoFuncionarios."</td>";
        echo "<td>Total: $".$costoTotal."</td>";
        echo "</tr>";

    } else {
        echo "0 resultados";
    }  
?>

  
  </tbody>
</table>

<?php    
    /* data para graficos */
    list($labels_frecuenciaCategorias,$cantidades_frecuenciaCategorias,$colores_frecuenciaCategorias) = obtenerDataGraficoFrecuenciaVSTipoOrdenPDF($dateTimeInicio,$dateTimeFin,$fechaFiltro);
    list($labels_costoMaterialesCategorias,$cantidades_costoMaterialesCategorias,$colores_costoMaterialesCategorias) = obtenerDataGraficoCostoMaterialesVSTipoTrabajoPDF($dateTimeInicio,$dateTimeFin,$fechaFiltro);
    list($labels_costoFuncionariosEjecutivosCategorias, $cantidades_costoFuncionariosEjecutivosCategorias,$colores_costoFuncionariosEjecutivosCategorias) = obtenerDataGraficoCostoFuncionariosEjecutivosVSTipoTrabajoPDF($dateTimeInicio,$dateTimeFin,$fechaFiltro);
    list($labels_costoTotalCategorias, $cantidades_costoTotalCategorias,$colores_costoTotalCategorias) = obtenerDataGraficoCostoTotalVSTipoTrabajoPDF($dateTimeInicio,$dateTimeFin,$fechaFiltro);
    list($labels_frecuenciaOrdenesPorHoras, $cantidades_frecuenciaOrdenesPorHoras,$colores_frecuenciaOrdenesPorHoras) = obtenerDataGraficoFrecuenciaVSOrdenesPorHorasPDF($dateTimeInicio,$dateTimeFin,$fechaFiltro);
?>

<div class="d-flex" style="page-break-before: always;">
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
<span>Grafico de Frecuencia VS TipoOrden</span>
<img src='https://quickchart.io/chart?c={type:"bar",data:{labels: <?php echo json_encode($labels_frecuenciaCategorias);?>, 
  datasets:[{label:"Categorias",data: <?php echo json_encode($cantidades_frecuenciaCategorias);?>}]}}' width="700px">
</div>



<div class="d-flex" style="page-break-before: always;">
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
<span>Grafico de CostoMateriales VS TipoTrabajo</span>
<img src='https://quickchart.io/chart?c={type:"bar",data:{labels: <?php echo json_encode($labels_costoMaterialesCategorias);?>, 
  datasets:[{label:"Categorias",data: <?php echo json_encode($cantidades_costoMaterialesCategorias);?>}]}}' width="700px">
</div>


<div class="d-flex" style="page-break-before: always;">
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
<span>Grafico de CostoFuncionariosEjecutivos VS TipoTrabajo</span>
<img src='https://quickchart.io/chart?c={type:"bar",data:{labels: <?php echo json_encode($labels_costoFuncionariosEjecutivosCategorias);?>, 
  datasets:[{label:"Categorias",data: <?php echo json_encode($cantidades_costoFuncionariosEjecutivosCategorias);?>}]}}' width="700px">
</div>



<div class="d-flex" style="page-break-before: always;">
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
<span>Grafico de CostoTotal VS TipoTrabajo</span>
<img src='https://quickchart.io/chart?c={type:"bar",data:{labels: <?php echo json_encode($labels_costoTotalCategorias);?>, 
  datasets:[{label:"Categorias",data: <?php echo json_encode($cantidades_costoTotalCategorias);?>}]}}' width="700px">
</div>


<div class="d-flex" style="page-break-before: always;">
<header>
        <nav class="navbar">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
            <img src="https://chitita.uta.cl/intranet/img/logo_uta_azul.png" width="300" height="70" class="d-inline-block align-top" alt="Logo Uta">
        </a>
        <div class="d-flex">  
        <?php
            /* consultaDatosUsuario */
            if(isset($DatosUsuario['nombre'])){
                echo "<div class='mx-3'> <i class='fa-solid fa-user'></i>";
                echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
                OpcionCerrarSesion();
            }
        ?>
        </div>
        </nav>
</header>
<span>Grafico de Frecuencia VS OrdenesPorHoras</span>
<img src='https://quickchart.io/chart?c={type:"line",data:{labels: <?php echo json_encode($labels_frecuenciaOrdenesPorHoras);?>, 
  datasets:[{label:"Categorias",data: <?php echo json_encode($cantidades_frecuenciaOrdenesPorHoras);?>}]}}' width="700px">
</div>

</body>
</html>

<?php
$html=ob_get_clean();
//echo $html;
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf= new Dompdf();
$options = $dompdf->getOptions();
$options-> set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper("letter");


$dompdf->render();


$reporte = $_GET['reporte'];
if($reporte=='ver'){
  $dompdf->stream("OrdenesTrabajo.pdf", array("Attachment" =>false));  //ver
}
if($reporte=='descargar'){
  $dompdf->stream("OrdenesTrabajo.pdf", array("Attachment" =>true)); //descargar
}

?>