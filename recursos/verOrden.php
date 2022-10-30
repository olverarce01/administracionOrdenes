<?php
    include "./conexion.php";
if(isset($_GET['Terminar'])){
    $id= $_GET['ver'];
    $sql = "UPDATE ordenes SET terminada= NOT terminada  WHERE id=".$id."";
    if (mysqli_query($conn, $sql)) {
    } else {
      echo "Error al Terminar: " . mysqli_error($conn);
    }
    
   /*  if($_GET['fechaTermino']){
        $sql = "UPDATE ordenes SET fechaTermino= CURRENT_TIMESTAMP  WHERE id=".$id."";

    }else{
        $sql = "UPDATE ordenes SET fechaTermino= NULL   WHERE id=".$id."";
    }
    if (mysqli_query($conn, $sql)) {
      echo "Orden Terminada";
    } else {
      echo "Error al Terminar: " . mysqli_error($conn);
    } */
  
}
if (isset($_POST['dateRecepcion'])&&isset($_POST['timeRecepcion'])&&isset($_POST['dateAsignacion'])&&isset($_POST['timeAsignacion'])) {
  
  $dateRecepcion = $_POST['dateRecepcion'];
  $timeRecepcion = $_POST['timeRecepcion'];

  $dateTimeRecepcion = date('Y-m-d H:i:s', strtotime("$dateRecepcion $timeRecepcion"));


  $dateAsignacion = $_POST['dateAsignacion'];
  $timeAsignacion = $_POST['timeAsignacion'];

  $dateTimeAsignacion = date('Y-m-d H:i:s', strtotime("$dateAsignacion $timeAsignacion"));

  
  $funcionarioEncargado= $_POST['funcionarioEncargado'];
  $tipoTrabajo= $_POST['tipoTrabajo'];

  $funcionariosEjecutores='';
  foreach ($_POST['funcionariosEjecutores'] as $selectedOption)
  {
    $funcionariosEjecutores .=$selectedOption.", ";
  }

  $materiales='';
  foreach ($_POST['materiales'] as $selectedOption)
  {
    $materiales .=$selectedOption.", ";
  }

  $dateTermino= $_POST['dateTermino'];
  $timeTermino= $_POST['timeTermino'];
  $dateTimeTermino = date('Y-m-d H:i:s', strtotime("$dateTermino $timeTermino"));



  $solicitudCompra= $_POST['solicitudCompra'];
  $observacion= $_POST['observacion'];
  $horasHombre= $_POST['horasHombre'];

  $precioMateriales= $_POST['precioMateriales'];
  $cantidadPersonas= $_POST['cantidadPersonas'];

  $precioFuncionariosEjecutores= $_POST['precioFuncionariosEjecutores'];
  $total= $precioMateriales + $precioFuncionariosEjecutores * $horasHombre;


$sql = "UPDATE ordenes SET fechaRecepcion= '".$dateTimeRecepcion."' 
                        , fechaAsignacion='".$dateAsignacion."'
                        , funcionarioEncargado='".$funcionarioEncargado."'
                        , tipoTrabajo='".$tipoTrabajo."'
                        , funcionariosEjecutores='".$funcionariosEjecutores."'
                        , fechaTermino='".$dateTimeTermino."'
                        , solicitudCompra= '".$solicitudCompra."'
                        , materiales= '".$materiales."'
                        , observacion= '".$observacion."'
                        , horasHombre= '".$horasHombre."'  
                        , precioMateriales= '".$precioMateriales."'
                        , cantidadPersonasInvolucradas= '".$cantidadPersonas."'
                        , precioFuncionariosEjecutores= '".$precioFuncionariosEjecutores."'
                        , costoTotal= '".$total."'
                        WHERE id=".$_GET['ver']."";
if (mysqli_query($conn, $sql)) {
  echo "Orden Actualizada";
} else {
  echo "Error al Terminar: " . mysqli_error($conn);
}


}
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





  <link rel="stylesheet" href="../css/verOrden.css">

  <title>Document</title>
</head>
<body>
  <?php
    $id= $_GET['ver'];
    $sql = "SELECT terminada FROM ordenes WHERE id='".$id."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        if($row["terminada"]){
        echo '<p>SOLICITUD DE TRABAJO O SERVICIO DLO <span class="badge badge-success">Terminada</span></p>';
      }else{
        echo '<p>SOLICITUD DE TRABAJO O SERVICIO DLO <span class="badge badge-warning">No terminada</span></p>';
      }
      }
    }
  ?> 
<p>Formulario interno</p>

<?php
        $sql = "SELECT * FROM ordenes, categorias, usuarios WHERE ordenes.id=".$id." && categorias.id=idCategoria && ordenes.anexo=usuarios.run";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            echo "<div id='".$_GET['ver']."' class='orden'>";

            echo "<div class='d-flex justify-content-between fila'>";
            echo "<div> <span style='font-weight:bold;'>NºSolicitud:</span> " . $_GET['ver']. " </div>";
            echo "<div> <span style='font-weight:bold;'>Fecha Solicitud:</span> " . $row["fechaCreacion"]. " </div>";
            echo "</div>";

            echo "<div class='d-flex justify-content-between fila'>";
            echo "<div> <span style='font-weight:bold;'>Ubicacion:</span> " . $row["ubicacion"]. " </div>";



            echo "<div> <span style='font-weight:bold;'>Anexo:</span>   ".$row["correo"]." ".$row["contacto"]. " </div>";
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
<form action="./verOrden.php?ver=<?php echo $_GET['ver']?>" method="POST">
<div class="orden">
          <div class="d-flex justify-content-between fila">
            <div>
                <span style="font-weight:bold;">Fecha de recepción: 
                </span>
                <?php   
                 $sql = "SELECT fechaRecepcion, CONVERT(fechaRecepcion, DATE) as dateRecepcion, CONVERT(fechaRecepcion, TIME) as timeRecepcion FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                       echo "<span class='datosMuestra' >".$row["fechaRecepcion"]."</span>";
                       echo '<input type="date" name="dateRecepcion" id="dateRecepcion" class="editando" value="'.$row["dateRecepcion"].'">';
                       echo '<input type="time" name="timeRecepcion" id="timeRecepcion" class="editando" value="'.$row["timeRecepcion"].'">';
                     }
                }else {
                        echo '<input type="date" name="dateRecepcion" id="dateRecepcion" class="editando">';
                        echo '<input type="time" name="timeRecepcion" id="timeRecepcion" class="editando">';
                }
                ?> 
                
              
            </div>
            <div>
                <span style="font-weight:bold;">Fecha de Asignación:
                </span>
                <?php
                 $sql = "SELECT fechaAsignacion, CONVERT(fechaAsignacion, DATE) as dateAsignacion, CONVERT(fechaAsignacion, TIME) as timeAsignacion FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["fechaAsignacion"]."</span>";
                       echo '<input type="date" name="dateAsignacion" id="dateAsignacion" class="editando" value="'.$row["dateAsignacion"].'">';
                       echo '<input type="time" name="timeAsignacion" id="timeAsignacion" class="editando" value="'.$row["timeAsignacion"].'">';
                     }
                  }else{
                      echo '<input type="date" name="dateAsignacion" id="dateAsignacion" class="editando">';
                      echo '<input type="time" name="timeAsignacion" id="timeAsignacion" class="editando">';
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
            
            <label for="" class="editando">
            <select name="funcionarioEncargado" id="funcionarioEncargado" class="js-example-basic-single">
              <?php
              $sql = "SELECT * FROM funcionarios";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {

                  while($row = mysqli_fetch_assoc($result)) {
                    if($funcionarioEncargado==$row['rut']){
                      echo "<option value='".$row['rut']."' selected>rut: ".$row['rut']." nombre: ".$row['nombre']."</option>";
                    }else{
                      echo "<option value='".$row['rut']."'>rut: ".$row['rut']." nombre: ".$row['nombre']."</option>";
                    }
                  }
                } else {
                  echo "0 resultados";
                }
              ?>
            </select>
            </label>
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
                       if($row["tipoTrabajo"] == 'INTERNO'){
                        echo '
                                <select name="tipoTrabajo" id="tipoTrabajo" class="editando">
                                <option value="INTERNO" selected>INTERNO</option>
                                <option value="EXTERNO">EXTERNO</option>
                                </select>
                              ';
                       }else{
                        echo  '
                                <select name="tipoTrabajo" id="tipoTrabajo" class="editando">
                                <option value="INTERNO">INTERNO</option>
                                <option value="EXTERNO" selected>EXTERNO</option>
                                </select>
                              ';
                       }
                   
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

            <label for="" class="editando">
            <select name="funcionariosEjecutores[]" id="selectFuncionariosEjecutores" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4">
              <?php
                $sql = "SELECT * FROM funcionarios";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {

                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='".$row['rut']."' precioHora='".$row['precioHora']."'>rut: ".$row['rut']." nombre: ".$row['nombre']."  precioHora: ".$row['precioHora']."</option>";
                    }
                  } else {
                    echo "0 resultados";
                  }
              ?>
                
            </select>
            </label>
            <input type="number" name="precioFuncionariosEjecutores" id="precioFuncionariosEjecutores" value="" class="editando" readonly>
          </div>
          <div class="d-flex justify-content-between fila">
            <div>
              <span style="font-weight:bold;">Fecha de Término:
              </span>
              
              <?php
                 $sql = "SELECT fechaTermino, CONVERT(fechaTermino, DATE) as dateTermino, CONVERT(fechaTermino, TIME) as timeTermino  FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
   
                     while($row = mysqli_fetch_assoc($result)) {
                      echo "<span class='datosMuestra' >".$row["fechaTermino"]."</span>";
                       echo '
                          <input type="date" name="dateTermino" id="dateTermino" class="editando" value="'.$row['dateTermino'].'">
                          <input type="time" name="timeTermino" id="timeTermino" class="editando" value="'.$row['timeTermino'].'">
                          ';
                     }
                  }else{
                    echo '
                          <input type="date" name="dateTermino" id="dateTermino" class="editando">
                          <input type="time" name="timeTermino" id="timeTermino" class="editando">
                          ';
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
                       echo "<span class='datosMuestra' >".$row["solicitudCompra"]."</span>";
                       echo '
                             <input type="text" name="solicitudCompra" id="solicitudCompra" class="editando" autocomplete="off" value="'.$row["solicitudCompra"].'">
                            ';
                     }
                   }else{
                      echo '
                      <input type="text" name="solicitudCompra" id="solicitudCompra" class="editando" autocomplete="off">
                      ';
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
                      echo "<span class='datosMuestra' >".$row["observacion"]."</span>";
                       echo '
                           <input type="text" name="observacion" id="observacion" class="editando" autocomplete="off" value="'.$row["observacion"].'">
                            ';
                     }
                   }else{
                        echo '
                           <input type="text" name="observacion" id="observacion" class="editando" autocomplete="off">
                            ';
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
                      echo "<span class='datosMuestra' >".$row["horasHombre"]."</span>";
                       echo '
                             <input type="number" name="horasHombre" id="horasHombre" class="editando" value="'.$row["horasHombre"].'">
                            ';
                     }
                   }else{
                    echo '
                          <input type="number" name="horasHombre" id="horasHombre" class="editando">
                        ';
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

              <input type="number" name="cantidadPersonas" id="cantidadPersonas" class="editando" READONLY>
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

              <label for="" class="editando">
              <select name="materiales[]" id="selectMateriales" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4">
                  <?php
                    $sql = "SELECT * FROM materiales";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {

                        while($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='".$row['nombre']."' precio='".$row['precioUnitario']."'> id: ".$row['id']." nombre: ".$row['nombre']." precioUnit: ".$row['precioUnitario']."</option>";
                        }
                      } else {
                        echo "0 resultados";
                      }
                  ?>
              </select>
              </label>
              <input type="number" name="precioMateriales" id="precioMateriales" class="editando" READONLY>

          </div>
          <div id="cantidadMateriales">

          </div>


            
          <?php
            echo '
            <a href="./verPDFOrden.php?id='.$id.'&reporte=ver" class="btn btn-danger" id="verPDF">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
            </svg>
            Ver PDF
            </a>
            ';

            echo '
            <a href="./verPDFOrden.php?id='.$id.'&reporte=descargar" class="btn btn-danger" id="descargarPDF">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
            </svg>
            Descargar PDF
            </a>       
            ';
          ?>

          <button class="btn btn-info" type="button" id="Editar">Editar</button>
          <button class="btn btn-info" id="Guardar" class="editando">Guardar</button>
          <button class="btn btn-info" type="button" id="Cancelar" class="editando">Cancelar</button>

          <?php
                $id= $_GET['ver'];

                 $sql = "SELECT terminada FROM ordenes WHERE id='".$id."'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
                     while($row = mysqli_fetch_assoc($result)) {
                       if($row["terminada"]){
                        echo '    
                        <a href="./verOrden.php?ver='.$id.'&Terminar=true"><button class="btn btn-warning" type="button" id="Terminar">Dejar Pendiente Orden</button></a> 
                        ';
                       }else{
                        echo '
                        <a href="./verOrden.php?ver='.$id.'&Terminar=true"><button class="btn btn-success" type="button" id="Terminar">Terminar Orden</button></a>
                        ';
                       }


                     }
                   }
            ?> 
</div>
</form>


<script>
    let materiales = new Map();
    let funcionariosEjecutores = new Map();

    function cantidadMaterial(value,precio,nombre){
        materiales.set(nombre,value*precio);
        precioTotal=0;
        materiales.forEach((values,keys)=>{
          precioTotal+=parseInt(values);
        });

        $("#precioMateriales").val(precioTotal);
    }





   $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
      
  $(function(){
    $("#Editar").click(function(){

      
      $(".datosMuestra").css("display","none");
      $(".datosMuestra").css("visibility","hidden");
      
      $(".editando, #Guardar, #Cancelar").css("display","inline");
      $(".editando, #Guardar, #Cancelar").css("visibility","visible");
      $(this).css("display","none");
      $(this).css("visibility","hidden");
      $("#Terminar").css("display","none");
      $("#Terminar").css("visibility","hidden");
      
    });
    $("#Cancelar").click(function(){
      $("#Editar").css("display","inline");
      $("#Editar").css("visibility","visible");
      $(".editando, #Guardar, #Cancelar").css("display","none");
      $(".editando, #Guardar, #Cancelar").css("visibility","hidden");
      $(".datosMuestra").css("display","inline");
      $(".datosMuestra").css("visibility","visible");
      $("#Terminar").css("display","inline");
      $("#Terminar").css("visibility","visible");
      
      
    });
    

    $(".multiselect-dropdown-list-wrapper").css("width","500px");
    $(".multiselect-dropdown").css("width","500px");

  
  
  
  })
    $("#descargarPDF").click(function(){
      function getPDF() {
        var doc = new jsPDF();
      
        var specialElementHandlers = {
          '#getPDF': function(element, renderer){
            return true;
          },
          '.controls': function(element, renderer){
            return true;
          }
        };
        doc.fromHTML($('body').get(0), 15, 15, {
          'width': 170, 
          'elementHandlers': specialElementHandlers
        });

        doc.save('Generated.pdf');
      }
    });
 
</script>
<script src="../js/selectsDinamicos.js"></script> 

</body>
</html>