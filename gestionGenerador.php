<?php
    include "./recursos/conexion.php";
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $prioridad = $_POST['prioridad'];
        $precioMateriales=$_POST['precioMateriales'];
        $tipoTrabajo=$_POST['tipoTrabajo'];
        $observacion=$_POST['observacion'];
        $solicitudCompra=$_POST['solicitudCompra'];
        $funcionarioEncargado=$_POST['funcionarioEncargado'];

        $dateAsignacion=$_POST['dateAsignacion'];
        $timeAsignacion=$_POST['timeAsignacion'];
        $fechaAsignacion= date('Y-m-d H:i:s', strtotime("$dateAsignacion $timeAsignacion"));


        $precioFuncionariosEjecutores=$_POST['precioFuncionariosEjecutores'];
        $materiales="";
        $funcionariosEjecutores="";
        $horasHombre=$_POST['horasHombre'];
        $cantidadPersonasInvolucradas=$_POST['cantidadPersonasInvolucradas'];

        $costoTotal=$precioMateriales+($precioFuncionariosEjecutores*$horasHombre);

        foreach ($_POST['materiales'] as $selectedOption)
        {
          $materiales .=$selectedOption.", ";
        }
        foreach ($_POST['funcionariosEjecutores'] as $selectedOption)
        {
          $funcionariosEjecutores .=$selectedOption.", ";
        }
        
        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (nombre, idCategoria, prioridad, materiales, precioMateriales, tipoTrabajo, observacion, solicitudCompra,funcionarioEncargado, fechaAsignacion,funcionariosEjecutores,precioFuncionariosEjecutores, horasHombre, cantidadPersonasInvolucradas, costoTotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'siisissssssiiii',$nombre, $categoria, $prioridad, $materiales, $precioMateriales, $tipoTrabajo, $observacion, $solicitudCompra, $funcionarioEncargado, $fechaAsignacion,$funcionariosEjecutores,$precioFuncionariosEjecutores, $horasHombre, $cantidadPersonasInvolucradas, $costoTotal);
        echo "Se agrego correctamente: ".$nombre." a la base de datos";
        
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


    <script src="multiselect-dropdown.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.1/chart.min.js" integrity="sha512-ymysWHuTOgC1h8/MdSMcEyWmmjtfSh/7PYIDCZYIjW9sfS5Lfs5VBGbkPYZSM11L+JzJ3+id+gXDF4ImKcnxgA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- fancyTable Js -->
    <script src="./js/fancyTable.js"></script>

    <script src="./js/actualizarGrafico.js"></script> 
    <script src="./js/categorias.js"></script> 
    <script src="./js/selectsDinamicos.js"></script> 
    <title>Document</title>
</head>
<body>
<p>FORMULARIO</p>
    <p>Gestion generador de ordenes</p>
  
    <form action="./gestionGenerador.php" method="post" id="formOrdenes">
        <input type="hidden" name="accion" value="crearOrden">
        <br>
        <label for="">Nombre Orden: </label>
        <input type="text" name="nombre" placeholder="nombre">
        <br>
        <label for="">
        Prioridad:
          <select name="prioridad" id="prioridad">
            <option value=0>Alta</option>
            <option value=1>Media Alta</option>
            <option value=2>Media</option>
            <option value=3>Media Baja</option>
            <option value=4>Baja</option>
            
          </select> 
              
        </label>
        <br>
        <label for="">Tipo de Servicio: </label>
        <select name="categoria" id="categoria">
            <?php
            $sql = "SELECT id, categoria FROM categorias";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='".$row["id"]."' class='categorias'>".$row["categoria"]."</option>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        </select>
        <img src="./recursos/mas.png" width="20" id="btnOpcionesCategorias">
        <div id="opcionesCategorias">
          <br>
          <input type="text" name="nombreCategoria" id="nombreCategoria" placeholder="agrega una categoria"><button type="button" onclick="agregarCategoria()">Agregar Categoria</button>
          <?php
            $sql = "SELECT id, categoria FROM categorias";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<div class='categorias'>".$row["categoria"]." <button type='button' onclick='eliminarCategoria(".$row["id"].")'>Eliminar</button> </div>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
            <br>
        </div>
        <br>
        <label for="">Materiales: 

        
          <select name="materiales[]" id="selectMateriales" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4">
          <?php
            $sql = "SELECT * FROM materiales";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='".$row['nombre']."' precio='".$row['precioUnitario']."'>".$row['nombre']." precioUnitario: ".$row['precioUnitario']."</option>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
          </select>
        </label>
        <div id="cantidadMateriales">

        </div>
        <label for="">
        Total precio material:
        <input type="number" name="precioMateriales" id="precioMateriales" value="" readonly>

        </label>
        <br>
        <label for="">
        Tipo de trabajo:
          <select name="tipoTrabajo" id="tipoTrabajo">
            <option value="interno">Interno</option>
            <option value="externo">Externo</option>
          </select> 
              
        </label>
        <br>
        <label for="">
        Observacion: 
              <input type="text" name="observacion" id="observacion">
        </label>
        <br>
        <label for="">
        Solicitud de compra: 
              <input type="text" name="solicitudCompra" id="solicitudCompra">
        </label>
        <br>
        <label for="">
          Funcionario encargado:
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
        <br>

        <label for="">
        Fecha de asignacion del trabajo:
          <input type="date" name="dateAsignacion" id="dateAsignacion">
          <input type="time" name="timeAsignacion" id="timeAsignacion">
        </label>

        <br>
        <label for="">Funcionarios Ejecutores:    
        <select name="funcionariosEjecutores[]" id="selectFuncionariosEjecutores" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4">
        <?php
          $sql = "SELECT * FROM funcionarios";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {

              while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['rut']."' cargo='".$row['cargo']."' precioHora='".$row['precioHora']."'>rut: ".$row['rut']." nombre: ".$row['nombre']." cargo: ".$row['cargo']." precioHora: ".$row['precioHora']."</option>";
              }
            } else {
              echo "0 resultados";
            }
          ?>
        </select>
        </label>
        <label for="">
        Total precioHora Ejecutores:
        <input type="number" name="precioFuncionariosEjecutores" id="precioFuncionariosEjecutores" value="" readonly>

        </label>

        <br>
        <label for="">
        Nº Horas Hombre: 
              <input type="number" name="horasHombre" id="horasHombre">
        </label>
        <label for="">
        Cantidad de personas involucradas: 
              <input type="number" name="cantidadPersonasInvolucradas" id="cantidadPersonasInvolucradas" value="" readonly>
        </label>
        <br>
        <input type="submit" value="Crear Orden">
        

    </form>   

    <script>
      $(document).ready(function() {
        $('.js-example-basic-single').select2();
      });


      let materiales = new Map();
      let funcionariosEjecutores = new Map();
      
      $("#opcionesCategorias").hide();

      function cantidadMaterial(value,precio,nombre){
        materiales.set(nombre,value*precio);
        precioTotal=0;
        materiales.forEach((values,keys)=>{
          precioTotal+=parseInt(values);
        });

        $("#precioMateriales").val(precioTotal);
        }
      
    </script>
</body>
</html>