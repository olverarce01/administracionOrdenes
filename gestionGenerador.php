<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";

    $DatosUsuario=ObtenerDatosBasicosUsuario('generador');
    if(!isset($DatosUsuario['nombre'])){ header('Location: /administracionOrdenes/login.php'); exit();}
?>

<?php
    include "./recursos/conexion.php";
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $ubicacion = $_POST['ubicacion'];
      
        $categoria = $_POST['categoria'];
        $prioridad = $_POST['prioridad'];
        $centroCosto = $_POST['centroCosto'];
        $funcionarioEncargado=  "".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."";
        $resumen = $_POST['resumen'];
        $detalle = $_POST['detalle'];



        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (ubicacion, anexo,idCategoria, prioridad, centroCosto, funcionarioContacto, resumen, detalle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssiissss',$ubicacion, $DatosUsuario['run'],$categoria, $prioridad, $centroCosto, $funcionarioEncargado, $resumen, $detalle);
        
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
    <?php libreriasCDN();?>

  
    <!-- estilos index y gestion -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/gestionGenerador.css">


    <title>GestionGenerador</title>
</head>
<body>  
  <header>
    <nav class="navbar">
      <!-- Logo UTA -->
      <a class="navbar-brand" href="#">
        <img src="./img/utaHorizontal.png" width="300" height="80" class="d-inline-block align-top" alt="Logo Uta">
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
        <label for="">FUNCIONARIO CONTACTO: 
        <?php
          echo "<span>  ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span>";
        ?>
        </label>      
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

<footer class="mt-5 py-5  text-muted text-center text-small">
  <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
</footer>
<script>
  $("#opcionesCategorias").hide();
  $("#btnOpcionesCategorias").click(function(){
    $("#opcionesCategorias").toggle();
  });
</script>


</body>
</html>