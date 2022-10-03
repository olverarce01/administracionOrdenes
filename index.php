<?php 
    include "./recursos/conexion.php";
    //agregar orden
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];

        
        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (nombre, idCategoria) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'si',$nombre, $categoria);
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

    if(isset($_GET['terminar'])){
        $id= $_GET['terminar'];


        $sql = "UPDATE ordenes SET terminada= NOT terminada  WHERE id=".$id."";

        if (mysqli_query($conn, $sql)) {
            echo "Orden Terminada";
          } else {
            echo "Error al Terminar: " . mysqli_error($conn);
          }
        
        if($_GET['fechaTermino']){
            $sql = "UPDATE ordenes SET fechaTermino= CURRENT_TIMESTAMP  WHERE id=".$id."";

        }else{
            $sql = "UPDATE ordenes SET fechaTermino= NULL   WHERE id=".$id."";
        }
        if (mysqli_query($conn, $sql)) {
          echo "Orden Terminada";
        } else {
          echo "Error al Terminar: " . mysqli_error($conn);
        }
    }
    $nombre='';
    $categoria='';
    $id=-1;
    if(isset($_GET['editar'])){
        $id= $_GET['editar'];
        $sql = "SELECT ordenes.nombre as nombre,categorias.categoria as categoria FROM ordenes, categorias WHERE ordenes.id='".$id."'  AND ordenes.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              //captura de valores para agregarlos al form de editar orden
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
    <form action="./" method="post" id="formOrdenes">
        <?php if(!isset($_GET['editar'])) : ?>
        <input type="hidden" name="accion" value="crearOrden">
        <br>
        <label for="">Nombre Orden: </label>
        <input type="text" name="nombre" placeholder="nombre">
        <br>
        <label for="">Categoria: </label>
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
        <label for="">Materiales: </label>


        <br>
        <input type="submit" value="Crear Orden">
        <?php else : ?>

        <input type="hidden" name="accion" value="editarOrden">
        
        <?php
            

            echo '<input type="hidden" name="id" value="'.$id.'">';
            echo '<br> <label for="">Nombre Orden: </label> <input type="text" name="nombre" placeholder="nombre" value="'.$nombre.'">';
            echo '<br> <label for="">Categoria: </label>';
            
        ?>
        <select name="categoria" id="categoria">
        <?php
            $sql = "SELECT id, categoria FROM categorias";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  if($categoria==$row["categoria"]){
                    echo "<option value='".$row["id"]."' selected>".$row["categoria"]."</option>";
                  }else{
                    echo "<option value='".$row["id"]."'>".$row["categoria"]."</option>";
                  }
                }
              } else {
                echo "0 resultados";
              }
        ?>
        </select>  
        <br>
        <input type="submit" value="Guardar edición">
        <a href="index.php"><button type="button">Anular edicion</button></a>
        <?php endif; ?>

    </form>    
    <p>LISTA DE ORDENES DE TRABAJO</p>
    <p>PENDIENTES</p>

    <?php
        //listar ordenes no terminadas
        $sql = "SELECT ordenes.id, nombre, idCategoria, categorias.categoria as categoria, fechaCreacion, fechaEdicion, terminada, fechaTermino FROM ordenes, categorias WHERE terminada=0 && categorias.id=idCategoria";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              echo "<div id='".$row["id"]."'> <a href='./recursos/verOrden.php?ver=".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]."</a> <a href='index.php?terminar=".$row["id"]."&fechaTermino=1'><button>Terminar</button></a> <a href='index.php?editar=".$row["id"]."'><button>Editar</button></a></div> <br>";
            }
          } else {
            echo "0 resultados";
          }
         
    ?>
    <p>FINALIZADAS</p>
    <?php
        //listar ordenes terminadas
        $sql = "SELECT ordenes.id, nombre, idCategoria, categorias.categoria as categoria, fechaCreacion, fechaEdicion, terminada, fechaTermino FROM ordenes, categorias WHERE terminada=1 && categorias.id=idCategoria";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
            echo "<div id='".$row["id"]."'> <a href='./recursos/verOrden.php?ver=".$row["id"]."'>Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]. " Termino:" . $row["fechaTermino"]." </a> <a href='index.php?terminar=".$row["id"]."&fechaTermino=0'><button>Dejar pendiente</button></a> <a href='index.php?editar=".$row["id"]."'><button>Editar</button></a></div> <br>";

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
        $sql = "SELECT categorias.categoria, rs.contador as contador FROM (SELECT idCategoria, count(*) as contador FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels =[];
        $cantidades= [];
        $colores= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels, "".$row["categoria"]."");
              array_push($cantidades, "".$row["contador"]."");
              
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
      async function actualizarGrafico() {
          await $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                    
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
      
        
        }










        $("#rangoFecha").hide();

        $(function() {    

        $("#formOrdenes").css('background-color','#DAF7A6')
        $('#<?php echo $id; ?>').css('color','blue');
        $( "#porFecha" ).click(function() {
          $("#rangoFecha").toggle();
        });
        

        $("input[type='date'], input[type='time'], #fechaFiltro").on('change', function() {
          $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                    
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
    <script>
      $("#opcionesCategorias").hide();
      $(function() {
        $( "#btnOpcionesCategorias" ).click(function() {
          $("#opcionesCategorias").toggle();
        });
      });
      async function  eliminarCategoria(id){
         await $.get(`./recursos/categorias.php?modo=eliminar&id=${id}`, function(mensaje, estado){   
        $("div").remove(".categorias");  
        $("option").remove(".categorias");            
          
        JSON.parse(mensaje).forEach(element => {
                $("#opcionesCategorias").append(`<div class='categorias'>${element.categoria} <button type='button' onclick='eliminarCategoria(${element.id})'>Eliminar</button> </div>`);
                $("#categoria").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
                $("#categoriaFiltro").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
        });
        });
        $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                    
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
      }
      async function agregarCategoria(){
        var Nombrecategoria=$("#nombreCategoria").val();
        await $.get(`./recursos/categorias.php?modo=agregar&nombre=${Nombrecategoria}`, function(mensaje, estado){   
        
        $("div").remove(".categorias");    
        $("option").remove(".categorias");            
        
        JSON.parse(mensaje).forEach(element => {
                $("#opcionesCategorias").append(`<div class='categorias'>${element.categoria} <button type='button' onclick='eliminarCategoria(${element.id})'>Eliminar</button> </div>`);
                $("#categoria").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
                $("#categoriaFiltro").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);


        });
        });
        $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                    
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
        $("#nombreCategoria").val("");
      }
    </script>
</body>
</html>

<?php
    mysqli_close($conn);
?>