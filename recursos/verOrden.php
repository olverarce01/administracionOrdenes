<?php

if (isset($_POST['dateRecepcion'])&&isset($_POST['timeRecepcion'])&&isset($_POST['dateAsignacion'])&&isset($_POST['timeAsignacion'])) {
  
  $dateRecepcion = $_POST['dateRecepcion'];
  $timeRecepcion = $_POST['timeRecepcion'];

  $dateAsignacion = $_POST['dateAsignacion'];
  $timeAsignacion = $_POST['timeAsignacion'];
  
  $funcionarioEncargado= $_POST['funcionarioEncargado'];

  $tipoTrabajo= $_POST['tipoTrabajo'];
  $funcionarioEjecutor= $_POST['funcionarioEjecutor'];

  $dateTermino= $_POST['dateTermino'];
  $timeTermino= $_POST['timeTermino'];


  $solicitudCompra= $_POST['solicitudCompra'];
  $observacion= $_POST['observacion'];
  $horasHombre= $_POST['horasHombre'];
  
  $cantidadPersonas= $_POST['cantidadPersonas'];
  $materiales= $_POST['materiales'];







  $stmt = mysqli_prepare($conn,"INSERT INTO");
  mysqli_stmt_bind_param($stmt, 'siiissss',$ubicacion, $anexo);
  echo "Se agrego correctamente: la orden a la base de datos";
  
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  
  <script src="../multiselect-dropdown.js" ></script>

  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




  <link rel="stylesheet" href="../css/verOrden.css">

  <title>Document</title>
</head>
<body>
  
<p>SOLICITUD DE TRABAJO O SERVICIO DLO</p>
<p>Formulario interno</p>

<?php
        include "./conexion.php";
        $id= $_GET['ver'];
        $sql = "SELECT * FROM ordenes, categorias WHERE ordenes.id=".$id." && categorias.id=idCategoria";
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
<form action="./verOrden.php?ver=<?php echo $_GET['ver']?>" method="POST">
<div class="orden">
          <div class="d-flex justify-content-between fila">
            <div>
                <span style="font-weight:bold;">Fecha de recepción:</span>
                <input type="date" name="dateRecepcion" id="dateRecepcion" class="editando">
                <input type="time" name="timeRecepcion" id="timeRecepcion" class="editando">
            </div>
            <div>
                <span style="font-weight:bold;">Fecha de Asignación:</span>
                <input type="date" name="dateAsignacion" id="dateAsignacion" class="editando">
                <input type="time" name="timeAsignacion" id="timeAsignacion" class="editando">
            </div>
          </div>
          <div>
            <span style="font-weight:bold;">Funcionario Encargado:</span>
            <label for="" class="editando">
            <select name="funcionarioEncargado" id="funcionarioEncargado" class="js-example-basic-single">
              <?php
              $sql = "SELECT * FROM funcionarios";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {

                  while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['rut']."'>rut: ".$row['rut']." nombre: ".$row['nombre']."</option>";
                  }
                } else {
                  echo "0 resultados";
                }
              ?>
            </select>
            </label>
          </div>
          <div>
            <span style="font-weight:bold;">Tipo de Trabajo:</span>
             <select name="tipoTrabajo" id="tipoTrabajo" class="editando">
              <option value="INTERNO">INTERNO</option>
            </select>
          </div>
          <div>
            <span style="font-weight:bold;">Funcionario Ejecutor:</span>

            <label for="" class="editando">
            <select name="funcionarioEjecutor" id="funcionarioEjecutor" multiple multiselect-search="true">
                <option value="0">0</option>
                <option value="1">1</option>
                
            </select>
            </label>
          </div>
          <div class="d-flex justify-content-between fila">
            <div>
              <span style="font-weight:bold;">Fecha de Término:</span>
              <input type="date" name="dateTermino" id="dateTermino" class="editando">
              <input type="time" name="timeTermino" id="timeTermino" class="editando">
            </div>
            <div>
              <span style="font-weight:bold;">Solicitud de Compra:</span>
              <input type="text" name="solicitudCompra" id="solicitudCompra" class="editando" autocomplete="off">
            </div>
          </div>
          <div>
              <span style="font-weight:bold;">Observación:</span>
              <input type="text" name="observacion" id="observacion" class="editando" autocomplete="off">

          </div>
          <div class="d-flex justify-content-between fila">
            <div>
              <span style="font-weight:bold;">Nº de Horas Hombre:</span>
              <input type="number" name="horasHombre" id="horasHombre" class="editando">
            </div>
            <div>
              <span style="font-weight:bold;">Cantidad de personas involucradas:</span>
              <input type="number" name="cantidadPersonas" id="cantidadPersonas" class="editando" READONLY>
            </div>
          </div>
          <div>
              <label for="" class="editando">
              <span style="font-weight:bold;">Material utilizado:</span>
              <select name="materiales[]" id="materiales" multiple multiselect-search="true">
              </select>
              </label>
          </div>
          <button class="btn btn-info" type="button" id="Editar">Editar</button>
          <button class="btn btn-info" id="Guardar" class="editando">Guardar</button>
          <button class="btn btn-info" type="button" id="Cancelar" class="editando">Cancelar</button>
          
</div>
</form>


<script>
   $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
      
  $(function(){
    $("#Editar").click(function(){
      $(".editando, #Guardar, #Cancelar").css("display","inline");
      $(".editando, #Guardar, #Cancelar").css("visibility","visible");
      $(this).css("display","none");
      $(this).css("visibility","hidden");
    });
    $("#Cancelar").click(function(){
      $("#Editar").css("display","inline");
      $("#Editar").css("visibility","visible");
      $(".editando, #Guardar, #Cancelar").css("display","none");
      $(".editando, #Guardar, #Cancelar").css("visibility","hidden");
    
      
    });
    
  })
</script>
</body>
</html>