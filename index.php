<?php 
    include "./recursos/conexion.php";
    //agregar orden
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];

        
        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (nombre, categoria) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss',$nombre, $categoria);
        echo "Se agrego correctamente: ".$nombre." a la base de datos";
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    if (isset($_POST['accion']) && $_POST['accion']=='editarOrden') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $id= $_POST['id'];

        $sql = "UPDATE ordenes SET nombre='".$nombre."', categoria='".$categoria."' WHERE id=".$id."";

        if (mysqli_query($conn, $sql)) {
            echo "Orden Actualizada";
          } else {
            echo "Error al actualizar: " . mysqli_error($conn);
          }
     
    }

    if(isset($_GET['eliminar'])){
        $id= $_GET['eliminar'];
        $sql = "DELETE FROM ordenes WHERE id='".$id."'";
        if (mysqli_query($conn, $sql)) {
            echo "Orden eliminada";
          } else {
            echo "Error al eliminar: " . mysqli_error($conn);
          }
    }
    $nombre='';
    $categoria='';
    $id=-1;
    if(isset($_GET['editar'])){
        $id= $_GET['editar'];
        $sql = "SELECT nombre,categoria FROM ordenes WHERE id='".$id."'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $nombre=$row["nombre"];
              $categoria=$row["categoria"];
            }
          }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" rel="stylesheet" href="./css/estilos.css">
    <script src="jquery/bootstrap.min.js"></script>

    <title>administracionOrdenes</title>
</head>
<body>

<header>
  <nav class="navbar navbar-light bg-light nav-color">
    <!-- Logo UTA -->
    <a class="navbar-brand" href="#">
      <img src="./img/utalogo.png" width="300" height="80" class="d-inline-block align-top" alt="Logo Uta">
    </a>

    <!-- Formulario para iniciar sesion -->
    <div class="form-login">
      <form class="form-inline my-1 mr-md-2 mt-sm-0" action="index.php" method="post" autocomplete="off">
        <div class="row">
          <div class="col">
            <i class="bi bi-file-earmark-person icono"></i>
            <input type="email" class="form-control my-1 w-md-25 w-sm-50" placeholder="Correo" name="correo">
            <i class="bi bi-lock-fill icono"></i>
            <input type="password" class="form-control my-1 w-md-25 w-sm-50" placeholder="Contraseña" name="contrasena">
            <button class="btn btn-outline-success my-1 mr-sm-2" type="submit">Acceder</button>
          </div>
        </div>
      </form>
    </div> 

  </nav>
</header>

<!-- contenido principal de la pagina -->
<main>

    <h2 class="pl-3 pt-4">FORMULARIO</h2>
    <?php if(!isset($_GET['editar'])) : ?>
    <br>
    <!--<h2>¡Crea una orden de trabajo!</h2>-->
    <?php else : ?>
    
    <?php 
        //echo "<h2>Editando orden de trabajo: ".$id."</h2>";    
    ?>
    <?php endif; ?>
    <form action="./" method="post">
        <?php if(!isset($_GET['editar'])) : ?>
        <!-- campos a rellenar para el formulario 
        <input type="hidden" name="accion" value="crearOrden">
        <input type="text" name="nombre" placeholder="nombre">
        <input type="text" name="categoria" placeholder="categoria">
        <input type="submit" value="Crear Orden">
        -->


        <!--Formulario con boostrap-->

        <form class="form-inline">
          <div class="color-orden container py-3 shadow-lg border border-dark rounded-lg">
            <h2 class="color-texto">¡Crea una orden de trabajo!</h2>

            <div class="form-group">
              <input type="hidden" name="accion" value="crearOrden">
            </div>
            <div class="form-group">
              <label for="inputPassword6" class="pl-3 color-texto">Nombre</label>
              <input type="text" id="inputPassword6" class="form-control mx-sm-3" style="width: 500px;" aria-describedby="passwordHelpInline" name="nombre" placeholder="nombre">
            </div>
            <div class="form-group">
              <label for="inputPassword6" class="pl-3 color-texto">Categoria</label>
              <input type="text" id="inputPassword6" class="form-control mx-sm-3" style="width: 500px;" aria-describedby="passwordHelpInline" name="categoria" placeholder="categoria">
            </div>
            <button type="submit" class="btn btn-primary ml-3" value="Crear Orden">Crear Orden</button>
          </div>
        </form>
        
        <br>
        
        <?php else : ?>

        <!--<input type="hidden" name="accion" value="editarOrden">-->
        <form class="form-inline">
          <div class="color-orden container py-3 shadow-lg border border-dark rounded-lg">
            <div class="form-group">
                <input type="hidden" name="accion" value="editarOrden">
            </div>
            
            <?php
                echo "<h2 class='color-texto'>Editando orden de trabajo: ".$id."</h2>"; 
                /*echo '<input type="hidden" name="id" value="'.$id.'">';
                echo '<input type="text" name="nombre" placeholder="nombre" value="'.$nombre.'">';
                echo '<input type="text" name="categoria" placeholder="categoria" value="'.$categoria.'">';*/
            
                echo '
                <div class="form-group">
                <input value="'.$id.'" type="hidden" id="inputPassword6" class="form-control mx-sm-3" style="width: 500px;" aria-describedby="passwordHelpInline" name="id" placeholder="id">
                </div>';
                echo '<div class="form-group">
                <label for="inputPassword6" class="pl-3">Nombre</label>
                <input value="'.$nombre.'" type="text" id="inputPassword6" class="form-control mx-sm-3" style="width: 500px;" aria-describedby="passwordHelpInline" name="nombre" placeholder="nombre">
                </div>';
                echo '<div class="form-group">
                <label for="inputPassword6" class="pl-3">Categoria</label>
                <input value="'.$categoria.'" type="text" id="inputPassword6" class="form-control mx-sm-3" style="width: 500px;" aria-describedby="passwordHelpInline" name="categoria" placeholder="categoria">
                </div>';
            ?>
            <!--<input type="submit" value="Guardar edición">
            <a href="index.php"><button type="button">Anular edicion</button></a>
            -->
            
            <button type="submit" class="btn btn-primary ml-3" value="Guardar edición">Guardar edición</button>
            <a href="index.php">
              <button type="button" class="btn btn-primary ml-3">Anular edicion</button>
            </a>
          </div>
        </form>

        <?php endif; ?>

    </form>    
    <br>
    <h2 class="pl-3">LISTA DE ORDENES DE TRABAJO</h2>
    <br>
    <table class="table table-striped table-dark ">
      
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">Nombre</th>
          <th scope="col">Categoria</th>
          <th scope="col">Creacion</th>
          <th scope="col">Edicion</th>
          <th scope="col">--</th>
          <th scope="col">--</th>
        </tr>
      </thead>

      <tbody>
      
    <?php
        //listar ordenes
        $sql = "SELECT id, nombre, categoria, fechaCreacion, fechaEdicion FROM ordenes";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              //echo "<div id='".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]." <a href='index.php?eliminar=".$row["id"]."'><button>Eliminar</button></a> <a href='index.php?editar=".$row["id"]."'><button>Editar</button></a></div> <br>";

              echo "
            <tr>
              <th scope='row' id='".$row["id"]."'> Id: " . $row["id"]. " </th>
              <td> " . $row["nombre"]. " </td>
              <td> " . $row["categoria"]. " </td>
              <td> " . $row["fechaCreacion"]. " </td>
              <td> " . $row["fechaEdicion"]." </td>
              <td> <a href='index.php?eliminar=".$row["id"]."' class='btn btn-primary ml-3'>Eliminar</a> </td>
              <td> <a href='index.php?editar=".$row["id"]."' class='btn btn-primary ml-3'>Editar</a> </td>
            </tr>";
            }
          } else {
            echo "0 resultados";
          }
         
    ?>
        
      </tbody>
      </div>
    </table>
    <br>
    <h2 class="pl-3">REPORTE</h2>
    <br>

    <!--
    <form action="./recursos/reporte.php" method="POST">
          <h3>Opciones Filtro:</h3>
          <br>

           Formulario normal
          <label for="">Categoria: </label>
          <select name="categoriaFiltro" id="categoriaFiltro">
            <option selected="selected" value="todas">todas</option>
            <option value="limpiar ventanas">limpiar ventanas</option>
            <option value="revisar camara">revisar camara</option>
            <option value="prender wifi">prender wifi</option>
          </select>

          <br>

          <input type='hidden' value='' name='porFecha'>
          <input type="checkbox" id="porFecha" name="porFecha" value="Activado">
          
          <select name="fechaFiltro" id="fechaFiltro">
            <option selected="selected" value="fechaCreacion">fechaCreacion</option>
            <option value="fechaEdicion">fechaEdicion</option>
          </select>

          <br>

          <label for="" id="rangoFecha">
              Desde <input type="date" name="dateInicio" id="dateInicio"> <input type="time" name="timeInicio" id="timeInicio">
              <br>
              Hasta <input type="date" name="dateFin" id="dateFin"> <input type="time" name="timeFin" id="timeFin">
          </label>

          

          <br>

          <label for="">
            Opcion reporte:
            <select name="reporte" id="reporte">
            <option selected="selected" value="ver">Ver</option>
            <option value="descargar">Descargar</option>
            </select>
          </label>
          
          <br>
          <button>Obtener reporte</button>
          
          <br>
          <br>

          </div>
    </form>

    -->

    <br>
    <form action="./recursos/reporte.php" method="POST">
      <div class="pl-3 color-orden container py-3 shadow-lg border border-dark rounded-lg">
        <div class="my-1">
          <p class="color-texto">Categoria</p>
          <label class="sr-only" for="inlineFormCustomSelect">Categoria:</label>
          <select class="custom-select " style="width: 300px;" name="categoriaFiltro" id="categoriaFiltro">
            <option selected="selected" value="todas">todas</option>
            <option value="limpiar ventanas">limpiar ventanas</option>
            <option value="revisar camara">revisar camara</option>
            <option value="prender wifi">prender wifi</option>
          </select>
        </div>
        <br>
        <div class="my-1">
          <p class="color-texto">Fecha/Creacion/Edicion</p>
          <div class="custom-control custom-checkbox mr-sm-2">
            <input type='hidden' value='' name='porFecha'>
            <input type="checkbox" class="custom-control-input" id="porFecha" name="porFecha" value="Activado">
            <label class="custom-control-label" for="porFecha"></label>
          </div>
        </div>

        <div class="my-1">
          <label class="sr-only" for="inlineFormCustomSelect">Categoria:</label>
          <select class="custom-select " style="width: 300px;" name="fechaFiltro" id="fechaFiltro">
            <option selected="selected" value="fechaCreacion">fechaCreacion</option>
            <option value="fechaEdicion">fechaEdicion</option>
          </select>
        </div>
        <br>
        <label for="" id="rangoFecha">
              Desde <input type="date" name="dateInicio" id="dateInicio"> <input type="time" name="timeInicio" id="timeInicio">
              <br>
              Hasta <input type="date" name="dateFin" id="dateFin"> <input type="time" name="timeFin" id="timeFin">
        </label>
        <br>
        <div class="my-1">
          <p class="color-texto">Opcion reporte</p>
          <label class="sr-only" for="">Opcion reporte:</label>
          <select class="custom-select " style="width: 300px;" name="reporte" id="reporte">
            <option selected="selected" value="ver">Ver</option>
            <option value="descargar">Descargar</option>
          </select>
        </div>

        <br>

        <div class=" my-1">
          <button type="submit" class="btn btn-primary">Obtener reporte</button>
        </div>
        
      </div>
    </form>

    <br>

    <div style="height:400px; width:700px" class="color-orden container py-3 shadow-lg border border-dark rounded-lg">
      <div id="chart-container" style="height:20vh; width:40vw;" >
        <canvas id="graphCanvas"></canvas>
      </div>
    </div>

   <?php
       
        //listar ordenes
        $sql = "SELECT categoria, count(*) FROM ordenes GROUP BY categoria";
        $result = mysqli_query($conn, $sql);
        $labels =[];
        $cantidades= [];
        $colores= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels, "".$row["categoria"]."");
              array_push($cantidades, "".$row["count(*)"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          }
         
    ?>

    <script>
    const ctx = document.getElementById('graphCanvas').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Categorias',
                data: <?php echo json_encode($cantidades); ?>,
                backgroundColor: <?php echo json_encode($colores); ?>,
              
                borderWidth: 1
            }]
        },
        options: {
            scales: {
              yAxes: {
                  ticks: {
                     stepSize: 1,
                  }
              }
            }
        }
    });

    </script>




    <script src="./jquery/jquery-3.6.1.min.js">
    </script>
    <script>
      function random_rgba() {
          var o = Math.round, r = Math.random, s = 255;
          return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + '0.7' + ')';
      }
        $("#rangoFecha").hide();

        $(function() {    

        $('#<?php echo $id; ?>').css('color','blue');
        $( "#porFecha" ).click(function() {
          $("#rangoFecha").toggle();
        });
        

        $("input[type='date'], input[type='time'], #fechaFiltro").on('change', function() {
          $.get(`./recursos/ordenes.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                    
          console.log(mensaje);
          if(mensaje === []){
            return;
          }

          var categorias=[];
          var contadores=[];
          var colores= [];

            JSON.parse(mensaje).forEach(element => {
                categorias.push(element.categoria);
                contadores.push(element.contador);
                colores.push(random_rgba());
           });

         
            myChart.destroy();
            myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                    labels: categorias,
                    datasets: [{
                    label: 'categorias',
                    data: contadores,
                    backgroundColor: colores, 
                    borderWidth: 1
                    }]
          },
            options: {
              scales: {
                yAxes: {
                  ticks: {
                     stepSize: 1,
                  }
                }
              }
            }
          });   

          
          });
      
        
        });

        });  


    </script>

</main>
<!-- footer de la pagina -->
<footer class="mt-5 py-5  text-muted text-center text-small color-footer">
    <p class="mb-1 color-texto">Universidad de Tarapacá – Universidad del Estado de Chile</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
</footer>

</body>
</html>

<?php
    mysqli_close($conn);
?>