<?php
    include "./recursos/conexion.php";
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $ubicacion = $_POST['ubicacion'];
        if(isset($_POST['anexo'])){
          $anexo = $_POST['anexo'];
        }else{
          $anexo = 0;
        }
        $categoria = $_POST['categoria'];
        $prioridad = $_POST['prioridad'];
        $centroCosto = $_POST['centroCosto'];
        $funcionarioEncargado=$_POST['funcionarioContacto'];
        $resumen = $_POST['resumen'];
        $detalle = $_POST['detalle'];



        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (ubicacion, anexo,idCategoria, prioridad, centroCosto, funcionarioContacto, resumen, detalle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'siiissss',$ubicacion, $anexo,$categoria, $prioridad, $centroCosto, $funcionarioEncargado, $resumen, $detalle);
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

    <link rel="stylesheet" href="./css/gestionGenerador.css">

    <title>Document</title>
</head>
<body>    
    <p id="tituloForm" class="text-info">GESTION GENERADOR DE ORDENES</p>
    <form action="./gestionGenerador.php" method="post" id="formOrdenes" class="m-5 p-3">
        <input type="hidden" name="accion" value="crearOrden">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="">UBICACION: </label>
            <select name="ubicacion" id="ubicacion" class="w-50">
                <?php
                $sql = "SELECT id, nombre FROM ubicacion";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
        
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='".$row["id"]."'> ".$row["id"]." ".$row["nombre"]."</option>";
                    }
                  } else {
                    echo "0 resultados";
                  }
                ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="">ANEXO: </label>
            <select name="anexo" id="anexo">
                <option value="0">-</option>
                <?php
                $sql = "SELECT id FROM ordenes";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
        
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='".$row["id"]."'> ".$row["id"]." ".$row["nombre"]."</option>";
                    }
                  } else {
                    echo "0 resultados";
                  }
                ?>
            </select>
          </div>
          <div class="col-md-4">
            <label for="">CENTRO DE COSTOS: </label>
            <select name="centroCosto" id="centroCosto" class="w-50">
                <?php
                $sql = "SELECT id, nombre FROM centro";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
        
                    while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='".$row["id"]."'> ".$row["id"]." ".$row["nombre"]."</option>";
                    }
                  } else {
                    echo "0 resultados";
                  }
                ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-4 my-3">
          <label for="">FUNCIONARIO CONTACTO: </label>
            <select name="funcionarioContacto" id="funcionarioContacto" class="js-example-basic-single">
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
          </div>
          <div class="col-md-4 my-3">
            <label for="">PRIORIDAD:</label>
            <select name="prioridad" id="prioridad">
              <option value=0>Alta</option>
              <option value=1>Media Alta</option>
              <option value=2>Media</option>
              <option value=3>Media Baja</option>
              <option value=4>Baja</option> 
            </select> 
          </div>
          <div class="col-md-4">
            <label for="">TIPO DE SERVICIO: </label>
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
            <img src="./recursos/mas.png" width="20" id="btnOpcionesCategorias" class="crossRotate">
            <div id="opcionesCategorias" class="p-2">
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
          
          </div>
        </div>
        
      <div class="form-row">
        <div class="col-md-4">
          <label for="">RESUMEN: </label>
          <input type="text" name="resumen" placeholder="resumen" required autocomplete="off">
        </div>
        <div class="col-md-4">
          <label for="">DETALLE: </label>
          <input type="text" name="detalle" placeholder="detalle" required autocomplete="off">
        </div>
      </div>
        <input type="submit" value="CREAR ORDEN" class="btn btn-info">
    </form>   

    <script>
     
      $("#opcionesCategorias").hide();

    </script>
</body>
</html>