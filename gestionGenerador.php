<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";

    $DatosUsuario=ObtenerDatosBasicosUsuario('generador');
    if(!isset($DatosUsuario['nombre'])){ header('Location: /administracionOrdenes/login.php'); exit();}
    $UsuarioRUN=$DatosUsuario['run'];
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

    <!-- Estilos NabBar -->
    <link rel="stylesheet" href="./css/navbar.css">

    <!-- estilos index y gestion -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/gestionGenerador.css">

    <title>Inicio</title>
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
    
  <div id="container">
    <div id="container-nav">
        <a href="./gestionGenerador.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-house" style="color:#374da5"></i>Inicio </div>  
        </a>   
        <a href="./misOrdenes.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-folder-open" style="color:black"></i> Mis ordenes</div>  
        </a>
        <a href="./servicios.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-truck-arrow-right" style="color:black"></i> Servicios</div>  
        </a>

    </div>

    <div id="main">
  <p id="tituloForm" class="text-info">GESTION GENERADOR DE ORDENES</p>
  <form action="./gestionGenerador.php" method="post" id="formOrdenes" class="m-4 p-4">
    <input type="hidden" name="accion" value="crearOrden">
    <div class="form-row">
      <div class="form-group col-md-5">



        <label for="">UBICACION: </label>
        <select name="ubicacion" id="ubicacion" class="js-example-basic-single" required>
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

      <div class="col-md-5">
        <label for="">CENTRO DE COSTOS: </label>
        <select name="centroCosto" id="centroCosto" class="js-example-basic-single" required>
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

      <div class="col-md-4 d-flex">
        <label for="">PRIORIDAD:</label>
        <?php
          $sql = "SELECT prioridad FROM usuarios WHERE run ='".$DatosUsuario['run']."'";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<input type='hidden' name='prioridad' value='".$row["prioridad"]."'>";

              if($row["prioridad"] == 0){
                echo "<h5><span class='badge badge-danger mx-3'>Alta</span></h5>";
              }else if ($row["prioridad"] == 1) {
                echo "<h5 class='badge badge-warning mx-3'>Media Alta</h5>";
              }else if ($row["prioridad"] == 2){
                echo "<h5 class='badge badge-primary mx-3'>Media</h5>";
              }else if ($row["prioridad"] == 3){
                echo "<h5 class='badge badge-info mx-3'>Media Baja</h5>";
              }else if ($row["prioridad"] == 4){
                echo "<h5 class='badge badge-success mx-3'>Media Baja</h5>";
              }
            }
          } else {
            echo "0 resultados";
          }
        ?>
      </div>
          
      <div class="col-md-8">


        <label for="">TIPO DE SERVICIO: </label>
        <select name="categoria" id="categoria" class="js-example-basic-single" required>
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
          
      </div>
    </div>
        
    <div class="form-row">
      <div class="col-md-4">
        <label for="">RESUMEN: </label>
        <input type="text" name="resumen" placeholder="Resumen" required autocomplete="off">
      </div>
      <div class="col-md-4">
        <label for="">DETALLE: </label>
        <input type="text" name="detalle" placeholder="Detalle" required autocomplete="off">
      </div>
    </div>
    <input type="submit" value="Enviar" id="enviar" class="btn btn-info">
  </form>   
  </div>
  </div>

<footer class="mt-5 py-5  text-muted text-center text-small">
  <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
</footer>




<script>
  $(".confirmacion").hide();
  $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>


</body>
</html>