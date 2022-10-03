<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Reporte</title>
</head>
<body>



    <?php
    include "conexion.php";

    echo "<h1>Reporte, añadir bootstrap</h1>";

    if (isset($_POST)) {
      $checkboxPorFecha = $_POST['porFecha'];


      $dateInicio = $_POST['dateInicio'];
      $timeInicio = $_POST['timeInicio'];
      $dateTimeInicio= date('Y-m-d H:i:s', strtotime("$dateInicio $timeInicio"));


      if($checkboxPorFecha=='Activado'){
        echo "Inicio".$dateTimeInicio."<br>";
      }

      $dateFin = $_POST['dateFin'];
      $timeFin = $_POST['timeFin'];
      $dateTimeFin= date('Y-m-d H:i:s', strtotime("$dateFin $timeFin"));

      
      if($checkboxPorFecha=='Activado'){
        echo "Fin".$dateTimeFin."<br>";
      }
    
      $fechaFiltro = $_POST['fechaFiltro'];
      
      $sql = "SELECT ordenes.id, nombre, categorias.categoria, fechaCreacion, fechaEdicion FROM ordenes, categorias where ordenes.idCategoria=categorias.id and ".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."'";
      
      $categoriaFiltro = $_POST['categoriaFiltro'];
      echo "categoria: ".$categoriaFiltro." <br>";



      if($categoriaFiltro == 'todas'){
        if($checkboxPorFecha==''){
          $sql = "SELECT ordenes.id, nombre, categorias.categoria, fechaCreacion, fechaEdicion FROM ordenes, categorias WHERE ordenes.idCategoria=categorias.id";
        }

      }
      else{
        $sql = "SELECT ordenes.id, nombre, categorias.categoria, fechaCreacion, fechaEdicion FROM ordenes, categorias where ordenes.idCategoria=categorias.id and ".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."' and categoria='".$categoriaFiltro."'";
        if($checkboxPorFecha==''){
          $sql = "SELECT ordenes.id, nombre, categorias.categoria, fechaCreacion, fechaEdicion FROM ordenes, categorias where ordenes.idCategoria=categorias.id and categoria='".$categoriaFiltro."'";
        }
      }



      $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        
            while($row = mysqli_fetch_assoc($result)) {
              echo "<div id='".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]."</div> <br>";
            }
        } else {
            echo "0 resultados";
        }  


    }
    ?>
        
    
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


$reporte = $_POST['reporte'];
if($reporte=='ver'){
  $dompdf->stream("archivo.pdf", array("Attachment" =>false)); 
}
if($reporte=='descargar'){
  $dompdf->stream("archivo.pdf", array("Attachment" =>true));
}

?>