<?php
ob_start();
    include "./funcionesLogin.php";

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
    <title>Document</title>
    <!-- <style>
        th, td {
        border: 1px solid black;
        }
    </style> -->
</head>
<body>
<table class="table table-hover">
  <thead>
    <tr>
      <th>NºOrden</th>
        <th scope="col">FechaAsignacion</th>
        <th scope="col">CostoMateriales</th>
        <th scope="col">CostoFuncionarios</th>
        <th scope="col">CostoTotal</th>
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

        $sql = "SELECT * FROM (SELECT * FROM ordenes WHERE (".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."')) as rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        //$datos = mysqli_fetch_all($result,MYSQLI_ASSOC); 
        //echo json_encode($datos);
        
    }else{
        $sql = "SELECT * FROM ordenes as rs, categorias WHERE rs.idCategoria=categorias.id";
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
            echo "<td>".$row['fechaAsignacion']."</td>";
            echo "<td>".$row['precioMateriales']."</td>";
            echo "<td>".$row['precioFuncionariosEjecutores']*$row['horasHombre']."</td>";
            echo "<td>".$row['costoTotal']."</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<th scope='row'>Totales</th>";
        echo "<td></td>";
        echo "<td>Total: ".$costoMateriales."</td>";
        echo "<td>Total: ".$costoFuncionarios."</td>";
        echo "<td>Total: ".$costoTotal."</td>";
        echo "</tr>";

    } else {
        echo "0 resultados";
    }  
?>

  
  </tbody>



</table>


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
  $dompdf->stream("archivo.pdf", array("Attachment" =>false));  //ver
}
if($reporte=='descargar'){
  $dompdf->stream("archivo.pdf", array("Attachment" =>true)); //descargar
}

?>