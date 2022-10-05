<?php 
    include "./recursos/conexion.php";
    //agregar orden
    if (isset($_POST['accion']) && $_POST['accion']=='crearOrden') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precioMateriales=$_POST['precioMateriales'];
        $precioFuncionariosEjecutores=$_POST['precioFuncionariosEjecutores'];
        $materiales="";
        $funcionariosEjecutores="";

        foreach ($_POST['materiales'] as $selectedOption)
        {
          $materiales .=$selectedOption.", ";
        }
        foreach ($_POST['funcionariosEjecutores'] as $selectedOption)
        {
          $funcionariosEjecutores .=$selectedOption.", ";
        }
        
        $stmt = mysqli_prepare($conn,"INSERT INTO ordenes (nombre, idCategoria, materiales, precioMateriales, funcionariosEjecutores, precioFuncionariosEjecutores) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sisisi',$nombre, $categoria, $materiales, $precioMateriales,$funcionariosEjecutores,$precioFuncionariosEjecutores);
        echo "Se agrego correctamente: ".$nombre." a la base de datos";
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
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
    $id=-1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="multiselect-dropdown.js" ></script>

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
        <div id="cantidadFuncionariosEjecutores">

        </div>
        <label for="">
        Total precioHora Ejecutores:
        <input type="number" name="precioFuncionariosEjecutores" id="precioFuncionariosEjecutores" value="" readonly>

        </label>
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
              echo "<div id='".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]." <a href='index.php?terminar=".$row["id"]."&fechaTermino=1'><button>Terminar</button></a> <a href='./recursos/verOrden.php?ver=".$row["id"]."'><button>Ver</button></a></div> <br>";
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
            echo "<div id='".$row["id"]."'> Id: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Creacion:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]. " Termino:" . $row["fechaTermino"]." <a href='index.php?terminar=".$row["id"]."&fechaTermino=0'><button>Dejar pendiente</button></a> <a href='./recursos/verOrden.php?ver=".$row["id"]."'><button>Ver</button></a></div> <br>";

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
    <button id="descargarCanvas">
      Descargar PDF
    </button>
    <button id="verCanvas">
      Ver PDF
    </button>

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
      let materiales = new Map();
      let funcionariosEjecutores = new Map();
      

       $("#descargarCanvas").click(function(){
        var canvas=$("#graphCanvas");
        
      var canvasImg = canvas[0].toDataURL("image/png", 1.0);
      var doc = new jsPDF();
      doc.setFillColor(0, 0,0,0);
      doc.rect(10, 10, 150, 160, "F");
      doc.addImage(canvasImg, 'png', 10, 10, 150, 100);
      doc.save('sample.pdf');



        });
        $("#verCanvas").click(function(){
        var canvas=$("#graphCanvas");
        
      var canvasImg = canvas[0].toDataURL("image/png", 1.0);
      var doc = new jsPDF();

      doc.setFillColor(0, 0,0,0);
      doc.rect(10, 10, 150, 160, "F");
      doc.addImage(canvasImg, 'png', 10, 10, 150, 100);
      var string = doc.output('datauristring');
      var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
      var x = window.open();
      x.document.open();
      x.document.write(embed);
      x.document.close();

        });
      $("#opcionesCategorias").hide();

      function cantidadMaterial(value,precio,nombre){
        materiales.set(nombre,value*precio);
        precioTotal=0;
        materiales.forEach((values,keys)=>{
          precioTotal+=parseInt(values);
        });

        $("#precioMateriales").val(precioTotal);
        }
  /*       function cantidadFuncionariosEjecutores(value,rut){
        funcionariosEjecutores.set(rut,value);
        precioTotal=0;
        funcionariosEjecutores.forEach((values,keys)=>{
          precioTotal+=parseInt(values);
        });

        $("#precioFuncionariosEjecutores").val(precioTotal);
        } */

      $(function() {
        $( "#btnOpcionesCategorias" ).click(function() {
          $("#opcionesCategorias").toggle();          
        });


        $("#selectMateriales").on("change",function(e){
            var optionsSelected=$("#selectMateriales option:selected",this);

            precioTotal=0;
            $("#cantidadMateriales").empty();
            materiales.clear();
            for (let index = 0; index < optionsSelected.prevObject[0].options.length; index++) {
              if(optionsSelected.prevObject[0].options[index].selected){

                materiales.set(optionsSelected.prevObject[0].options[index].value, optionsSelected.prevObject[0].options[index].attributes.precio.value);
                $("#cantidadMateriales").append( `material: ${optionsSelected.prevObject[0].options[index].value} cantidad : <input type='number' value='1' onChange='cantidadMaterial(value,${optionsSelected.prevObject[0].options[index].attributes.precio.value},"${optionsSelected.prevObject[0].options[index].value}")'/> <br>` );
              }
            }
            materiales.forEach((values,keys)=>{
                  precioTotal+=parseInt(values);
                });
            $("#precioMateriales").val(precioTotal);


          });
          $("#selectFuncionariosEjecutores").on("change",function(e){
            var optionsSelected=$("#selectFuncionariosEjecutores option:selected",this);

            precioTotal=0;
            $("#cantidadFuncionariosEjecutores").empty();
            funcionariosEjecutores.clear();
            for (let index = 0; index < optionsSelected.prevObject[0].options.length; index++) {
              if(optionsSelected.prevObject[0].options[index].selected){
                funcionariosEjecutores.set(optionsSelected.prevObject[0].options[index].value, optionsSelected.prevObject[0].options[index].attributes.precioHora.value);

                $("#cantidadFuncionariosEjecutores").append( `funcionario: ${optionsSelected.prevObject[0].options[index].value} precioHora : ${optionsSelected.prevObject[0].options[index].attributes.precioHora.value} <br>` );
              }
            }
            funcionariosEjecutores.forEach((values,keys)=>{
                  precioTotal+=parseInt(values);
                });
            $("#precioFuncionariosEjecutores").val(precioTotal);

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