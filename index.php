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
    <title>administracionOrdenes</title>
</head>
<body>
    <p>FORMULARIO</p>
    <?php if(!isset($_GET['editar'])) : ?>
    <p>¡Crea una orden de trabajo!</p>
    <?php else : ?>
    
    <?php 
        echo "<p>Editando orden de trabajo: ".$id."</p>";    
    ?>
    <?php endif; ?>
    <form action="./" method="post">
        <?php if(!isset($_GET['editar'])) : ?>
        <input type="hidden" name="accion" value="crearOrden">
        <input type="text" name="nombre" placeholder="nombre">
        <input type="text" name="categoria" placeholder="categoria">
        <input type="submit" value="Crear Orden">
        <?php else : ?>

        <input type="hidden" name="accion" value="editarOrden">
        <?php
            echo '<input type="hidden" name="id" value="'.$id.'">';
            echo '<input type="text" name="nombre" placeholder="nombre" value="'.$nombre.'">';
            echo '<input type="text" name="categoria" placeholder="categoria" value="'.$categoria.'">';
        ?>
        <input type="submit" value="Guardar edición">
        <a href="index.php"><button type="button">Anular edicion</button></a>
        <?php endif; ?>

    </form>    
    <p>LISTA DE ORDENES DE TRABAJO</p>

    <?php
        //listar ordenes
        $sql = "SELECT id, nombre, categoria, fechaCreacion, fechaEdicion FROM ordenes";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              echo "<div id='".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]." <a href='index.php?eliminar=".$row["id"]."'><button>Eliminar</button></a> <a href='index.php?editar=".$row["id"]."'><button>Editar</button></a></div> <br>";
            }
          } else {
            echo "0 resultados";
          }
         
    ?>
    <p>REPORTE</p>
    <form action="./recursos/reporte.php" method="POST">
            Opciones Filtro:
          <br>
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
    </form>

    <div id="chart-container" style="position: relative; height:20vh; width:40vw;">
      <canvas id="graphCanvas"></canvas>
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
</body>
</html>

<?php
    mysqli_close($conn);
?>