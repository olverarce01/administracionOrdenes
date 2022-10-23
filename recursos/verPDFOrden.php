<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="../multiselect-dropdown.js" ></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>


  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>



  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  <style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    p{
        font-size: 30px;
        text-align: center;
    }
    .orden{
        border: 1px solid black;
        margin: 10px;
        padding: 20px;
    }
    .editando, #Cancelar, #Guardar{
        display: none;
        visibility: hidden;
    }


  </style>



  <title>Document</title>
</head>
<body>
  
<p>SOLICITUD DE TRABAJO O SERVICIO DLO</p>
<p>Formulario interno</p>

<?php
        include "./conexion.php";
        $id= $_GET['id'];
        $sql = "SELECT ordenes.*, categorias.categoria FROM ordenes, categorias WHERE ordenes.id=".$id." && categorias.id=idCategoria";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            echo "<div id='".$row["id"]."' class='orden'>";

            echo "<div class='d-flex justify-content-between fila'>";
            echo "<div> <span style='font-weight:bold;'>NºSolicitud:</span> " . $row["id"]. " </div>";
            echo "<div> <span style='font-weight:bold;'>Fecha Solicitud:</span> " . $row["fechaCreacion"]. " </div>";
            echo "</div>";

            echo "<div class='d-flex justify-content-between fila'>";
            echo "<div> <span style='font-weight:bold;'>Ubicacion:</span> " . $row["ubicacion"]. " </div>";
            echo "<div> <span style='font-weight:bold;'>Anexo:</span> " . $row["anexo"]. " </div>";
            echo "</div>";

            echo "<div> <span style='font-weight:bold;'>Centro de Costo:</span> " . $row["centroCosto"]. " </div>";
            echo "<div> <span style='font-weight:bold;'>Funcionario Contacto:</span> " . $row["funcionarioContacto"]." </div>";
            echo "<div> <span style='font-weight:bold;'>Tipo de Servicio:</span> " . $row["categoria"]." </div>";
            echo "<div> <span style='font-weight:bold;'>Resumen:</span> " . $row["resumen"]." </div>";
            echo "<div> <span style='font-weight:bold;'>Detalle:</span> " . $row["detalle"]." </div>";

            echo "</div>";

            }
          } else {
            echo "0 resultados";
          }
         
?>
<div class="orden">
          <div class="d-flex justify-content-between fila">
            <div>
                <span style="font-weight:bold;">Fecha de recepción: 
                </span>
                <?php            
                $sql = "SELECT fechaRecepcion FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["fechaRecepcion"]."</span";
                          }
                        }
                ?> 

              
            </div>
            <div>
                <span style="font-weight:bold;">Fecha de Asignación:
                </span>
                <?php            
                $sql = "SELECT fechaAsignacion FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["fechaAsignacion"]."</span";
                          }
                        }
                ?> 

            </div>
          </div>
          <div>
            <span style="font-weight:bold;">Funcionario Encargado:
            </span>
            <?php
                 $funcionarioEncargado = '';

                 $sql = "SELECT funcionarioEncargado FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                       echo "<span class='datosMuestra' >".$row["funcionarioEncargado"]."</span>";

                       $funcionarioEncargado = $row["funcionarioEncargado"];
                     }
                   }
            ?> 
            
          </div>
          <div>
            <span style="font-weight:bold;">Tipo de Trabajo:
            </span>
            <?php
                 
                 $sql = "SELECT tipoTrabajo FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["tipoTrabajo"]."</span>";
                     }
                   }
            ?> 

           
          </div>
          <div>
            <span style="font-weight:bold;">Funcionario Ejecutor:
            </span>
            <?php
            
                 $sql = "SELECT funcionariosEjecutores FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["funcionariosEjecutores"]."</span>";
                     }
                   }
            ?> 

          </div>
          <div class="d-flex justify-content-between fila">
            <div>
              <span style="font-weight:bold;">Fecha de Término:
              </span>
              <?php            
                $sql = "SELECT fechaTermino FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["fechaTermino"]."</span";
                          }
                        }
              ?>   
            

              
            </div>
            <div>
              <span style="font-weight:bold;">Solicitud de Compra:
              </span>
              <?php            
                $sql = "SELECT solicitudCompra FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["solicitudCompra"]."</span";
                          }
                        }
              ?>           

            </div>
          </div>
          <div>
              <span style="font-weight:bold;">Observación:</span>
              <?php            
                $sql = "SELECT observacion FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["observacion"]."</span";
                          }
                        }
              ?>

          </div>
          <div class="d-flex justify-content-between fila">
            <div>
              <span style="font-weight:bold;">Nº de Horas Hombre:
              </span>
              <?php            
                $sql = "SELECT horasHombre FROM ordenes WHERE id='".$id."'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          echo "<span>".$row["horasHombre"]."</span";
                          }
                        }
              ?>             

            </div>
            <div>
              <span style="font-weight:bold;">Cantidad de personas involucradas:
              </span>
              <?php
                 $sql = "SELECT cantidadPersonasInvolucradas FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["cantidadPersonasInvolucradas"]."</span>";
                     }
                   }
              ?> 

            </div>
          </div>
          <div>
              <span style="font-weight:bold;">Material utilizado:
              </span>
              <?php
                 $sql = "SELECT materiales FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["materiales"]."</span>";
                     }
                   }
              ?> 


          </div>
          
          
</div>

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