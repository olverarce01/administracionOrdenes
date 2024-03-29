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


    <title>misOrdenes</title>
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
          <div id="container-option"> <i class="fa-solid fa-folder-open" style="color:#374da5"></i> Mis ordenes</div>  
        </a>
        <a href="./servicios.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-truck-arrow-right" style="color:black"></i> Servicios</div>  
        </a>

    </div>

      <!-- tabla de ordenes -->
      <div id="main">
        <p id="tituloForm" class="text-info">Mis Ordenes Generadas</p>

        <div id="main-infoOrdenes">
            <div id="tablaOrdenes">
                <table id="tablaO" class="table" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="th-sm">NºOrden</th>
                            <th class="th-sm">Prioridad</th>
                            <th class="th-sm">Tipo de trabajo</th>
                            <th class="th-sm">Fecha de Recepcion</th>
                            <th class="th-sm">Fecha de Asignacion</th>
                            <th class="th-sm">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //listar ordenes no terminadas
                        $sql = "SELECT ordenes.id, nombre, idCategoria, categorias.categoria as categoria, fechaCreacion, fechaAsignacion, fechaEdicion, terminada, fechaTermino, prioridad FROM ordenes, categorias WHERE categorias.id=idCategoria AND ordenes.anexo='".$UsuarioRUN."'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row' id='".$row["id"]."' class='tdOrdenes'>" . $row["id"]. "</th>";
                                if($row["prioridad"]==0){
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <span class='badge badge-danger'>Alta</span> </td>";
                                }
                                else if($row["prioridad"]==1){
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <span class='badge badge-warning'>Media Alta</span> </td>";
                                }
                                else if($row["prioridad"]==2){
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <span class='badge badge-primary'>Media</span> </td>";
                                }
                                else if($row["prioridad"]==3){
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <span class='badge badge-info'>Media Baja</span> </td>";
                                }else{
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'> <span class='badge badge-success'>Baja</span> </td>";
                                }
                                echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["categoria"]. "</td>";
                                echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["fechaCreacion"]. "</td>";
                                echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["fechaAsignacion"]. "</td>";

                                if($row["terminada"]==0){
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-warning'>Pendiente</span></td>";
                                }
                                else{
                                    echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-success'>Terminada</span></td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "0 resultados";
                        }        
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NºOrden
                            </th>
                            <th>Prioridad
                            </th>
                            <th>Tipo de trabajo
                            </th>
                            <th>Fecha de Asignacion
                            </th>
                            <th>Estado
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
/* opciones de tabla de ordenes */
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