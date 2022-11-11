<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";

    $DatosUsuario=ObtenerDatosBasicosUsuario('generador');
    if(!isset($DatosUsuario['nombre'])){ header('Location: /administracionOrdenes/login.php'); exit();}
    $UsuarioRUN=$DatosUsuario['run'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php libreriasCDN();?>

      <!-- bootstrap -->
  <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- jquery -->
  <script src="jquery/jquery-3.6.1.min.js"></script>
  <!-- jquerytable -->
  <script src="./js/jquery.dataTables.min.js" defer></script>



    <!-- Estilos NabBar -->
    <link rel="stylesheet" href="./css/navbar.css">

    <!-- estilos index y gestion -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/gestionGenerador.css">


    <title>Tipos de servicio</title>
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
          <div id="container-option"> <i class="fa-solid fa-house" style="color:black"></i>Inicio </div>  
        </a>   
        <a href="./misOrdenes.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-folder-open" style="color:black"></i> Mis ordenes</div>  
        </a>
        <a href="./servicios.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-truck-arrow-right" style="color:#374da5"></i> Servicios</div>  
        </a>

    </div>

    <div id="main">
      <div class="mx-5 my-3 alert alert-primary" role="alert">
        <p class="font-weight-bold">Agregar nuevo servicio</p>
        <form action="./recursos/agregarServicio.php" method="POST">
          <span>Nombre: <input type="text" name="nombre" placeholder="nombre" required></span>
          <input type="submit" value="Agregar" class="btn btn-primary my-2">        
        </form>
      </div>

      <div id="main-infoOrdenes">
        <div id="tablaOrdenes">
          <table id="tablaO" class="table" cellspacing="0">
            <thead>
              <tr>
                <th class="th-sm">Id</th>
                <th class="th-sm">Nombre</th>
                <th class="th-sm">Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM categorias";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<th scope='row' id='".$row["id"]."' class='tdOrdenes'>" . $row["id"]. "</th>";
                    echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["categoria"]. "</td>";
                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <a href='./recursos/eliminarServicio.php?id=".$row["id"]."'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";                                
                    echo "</tr>";
                  }
                } else {
                    echo "0 resultados";
                }        
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>id
                </th>
                <th>nombre
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

 




<footer class="mt-5 py-5  text-muted text-center text-small">
  <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
</footer>


<script>
$(document).ready(function () {
    $('#tablaO').dataTable({
        initComplete: function () {
        this.api().columns().every( function () {
            var column = this;
            var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Buscar">`)
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change input', function () {
                        var val = $(this).val()
                        column
                        .search( val ? val : '', true, false )
                        .draw();
                        } );
        });
        }
    });
});
</script>

</body>
</html>