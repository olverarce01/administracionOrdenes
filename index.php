<?php 
    include "./recursos/conexion.php";   
    $id=-1;
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
    
    <link rel="stylesheet" href="./css/index.css">

    <title>administracionOrdenes</title>
</head>
<body>

<p>REPORTE</p>
    <form>
            Opciones Filtro:
          <br>
          <input type='hidden' value='' name='porFecha'>

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

          <br>
          <button id="descargarCanvas" type="button">
            Descargar PDF
          </button>
          <button id="verCanvas" type="button">
            Ver PDF
          </button>
    </form>
    <div id="chart-container">
      <div id="divFrecuenciaCategorias">
        <p>Cantidad de ordenes por categoria</p>
        <canvas id="frecuenciaCategorias"></canvas>
      </div>
      <div id="divCostoMaterialesCategorias">
      <p>Costo materiales por categoria</p>
      <canvas id="costoMaterialesCategorias"></canvas>
      </div>
      <div id="divCostoFuncionariosEjecutivosCategorias">
      <p>Costo funcionarios ejecutivos por categoria</p>
      <canvas id="costoFuncionariosEjecutivosCategorias"></canvas>
      </div>
      <div id="divCostoTotalCategorias">
      <p>Costo Total por categoria</p>
      <canvas id="costoTotalCategorias"></canvas>
      </div>
      <div id="divFrecuenciaOrdenesPorHoras">
      <p>Frecuencia de ordenes por Horas de trabajo</p>
      <canvas id="frecuenciaOrdenesPorHoras"></canvas>
      </div>
    </div>

  <div id="container-cards">
    <div class="card cardDashboard" style="width: 18rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT count(*) as contador FROM ordenes WHERE terminada=1";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-success'>".$row["contador"]." Terminadas</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/8509/8509757.png" alt="" width="45" height="45">
      </div>
    </div>


    <div class="card cardDashboard" style="width: 18rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT count(*) as contador FROM ordenes WHERE terminada=0";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-warning'>".$row["contador"]." Pendientes</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/8509/8509817.png" alt="" width="45" height="45">
      </div>
    </div>

    <div class="card cardDashboard" style="width: 18rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT count(*) as contador FROM ordenes WHERE prioridad=0";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-danger'>".$row["contador"]." Urgentes</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/8509/8509757.png" alt="" width="45" height="45">
      </div>
    </div>

    <div class="card cardDashboard" style="width: 30rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT sum(costoTotal) as total FROM ordenes";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-info'>$".$row["total"]."</p><p class='pDash'>Ordenes</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/781/781902.png" alt="" width="45" height="45">
      </div>
    </div>
    <div class="card cardDashboard" style="width: 30rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT sum(precioMateriales) as total FROM ordenes";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-info'>$".$row["total"]."</p><p class='pDash'>Materiales</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/3371/3371713.png" alt="" width="45" height="45">
      </div>
    </div>
    <div class="card cardDashboard" style="width: 30rem;">
      <div class="card-body cardDash">
        <?php
            $sql = "SELECT sum(precioFuncionariosEjecutores*horasHombre) as total FROM ordenes";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
    
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<p class='pDash text-info'>$".$row["total"]."</p><p class='pDash'>ManoObra</p>";
                }
              } else {
                echo "0 resultados";
              }
            ?>
        <img src="https://cdn-icons-png.flaticon.com/512/7424/7424725.png" alt="" width="45" height="45">
      </div>
    </div>
  </div>
    <table id="tablaOrdenes" class="container-ordenes" class="table table-striped sampleTable">
    <thead>
    <tr>
      <th>NºOrden</th>
      <th>Prioridad</th>
      <th>Tipo de trabajo</th>
      <th>Fecha de Asignacion</th>
      <th>Estado</th>
      <th>Accion</th>

    </tr>
    </thead>
    <tbody>
    <?php
        //listar ordenes no terminadas
        $sql = "SELECT ordenes.id, nombre, idCategoria, categorias.categoria as categoria, fechaAsignacion, fechaEdicion, terminada, fechaTermino, prioridad FROM ordenes, categorias WHERE categorias.id=idCategoria";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["id"]. "</td>";
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
              echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["fechaAsignacion"]. "</td>";
              if($row["terminada"]==0){
                echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-warning'>Pendiente</span></td>";
                echo "<td><a href='./recursos/verOrden.php?ver=".$row["id"]."'><button>Ver</button></a></td>";

              }
              else{
                echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-success'>Terminada</span></td>";
                echo "<td><a href='./recursos/verOrden.php?ver=".$row["id"]."'><button>Ver</button></a></td> <br>";

              }


              echo "</tr>";
            }
          } else {
            echo "0 resultados";
          }
         
    ?>
    </tbody>
</table>

   
   <?php    
        //listar ordenes frecuenciaCategorias
        $sql = "SELECT categorias.categoria, rs.contador as contador FROM (SELECT idCategoria, count(*) as contador FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_frecuenciaCategorias =[];
        $cantidades_frecuenciaCategorias= [];
        $colores_frecuenciaCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_frecuenciaCategorias, "".$row["categoria"]."");
              array_push($cantidades_frecuenciaCategorias, "".$row["contador"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_frecuenciaCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          } 
    ?>
   <?php    
        //listar ordenes costoMaterialesCategorias
        $sql = "SELECT categorias.categoria, rs.precioMateriales as precioMateriales FROM (SELECT idCategoria, sum(precioMateriales) as precioMateriales FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoMaterialesCategorias =[];
        $cantidades_costoMaterialesCategorias= [];
        $colores_costoMaterialesCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoMaterialesCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoMaterialesCategorias, "".$row["precioMateriales"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoMaterialesCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          } 
    ?>
<?php    
        //listar ordenes costoFuncionariosEjecutivosCategorias
        $sql = "SELECT categorias.categoria, precioFuncionariosEjecutores FROM (SELECT idCategoria, sum(precioFuncionariosEjecutores*horasHombre) as precioFuncionariosEjecutores FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoFuncionariosEjecutivosCategorias =[];
        $cantidades_costoFuncionariosEjecutivosCategorias= [];
        $colores_costoFuncionariosEjecutivosCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoFuncionariosEjecutivosCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoFuncionariosEjecutivosCategorias, "".$row["precioFuncionariosEjecutores"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoFuncionariosEjecutivosCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          } 
?>
<?php    
        //listar ordenes costoTotalCategorias
        $sql = "SELECT categorias.categoria, costosTotal FROM (SELECT idCategoria, sum(costoTotal) as costosTotal FROM ordenes GROUP BY idCategoria) rs, categorias WHERE rs.idCategoria=categorias.id";
        $result = mysqli_query($conn, $sql);
        $labels_costoTotalCategorias =[];
        $cantidades_costoTotalCategorias= [];
        $colores_costoTotalCategorias= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_costoTotalCategorias, "".$row["categoria"]."");
              array_push($cantidades_costoTotalCategorias, "".$row["costosTotal"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_costoTotalCategorias, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          } 
?>
<?php    
        //listar ordenes frecuenciaOrdenesPorHoras
        $sql = "SELECT horasHombre, count(*) as frecuenciaHoras FROM ordenes GROUP BY horasHombre";
        $result = mysqli_query($conn, $sql);
        $labels_frecuenciaOrdenesPorHoras =[];
        $cantidades_frecuenciaOrdenesPorHoras= [];
        $colores_frecuenciaOrdenesPorHoras= [];

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
              array_push($labels_frecuenciaOrdenesPorHoras, "".$row["horasHombre"]."");
              array_push($cantidades_frecuenciaOrdenesPorHoras, "".$row["frecuenciaHoras"]."");
              
              $rgbColor= array();
              foreach(array('r', 'g', 'b') as $color){
                $rgbColor[$color] = mt_rand(0, 255);
              }
              array_push($colores_frecuenciaOrdenesPorHoras, "rgba(".$rgbColor["r"].",".$rgbColor["g"].",".$rgbColor["b"].",0.7)");

            }
          } else {
            echo "0 resultados";
          } 
?>
    <script>
    window.jsPDF = window.jspdf.jsPDF;
    const bgColor ={
      id: 'bgColor',
      beforeDraw: (chart, options)=>{
        const {ctx, width, height} = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0,0 ,width, height);
        ctx.restore();
      }
    }

    const frecuenciaCategorias = document.getElementById('frecuenciaCategorias').getContext('2d');
    var ChartfrecuenciaCategorias = new Chart(frecuenciaCategorias, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_frecuenciaCategorias); ?>,
            datasets: [{
                label: 'Categorias',
                data: <?php echo json_encode($cantidades_frecuenciaCategorias); ?>,
                backgroundColor: <?php echo json_encode($colores_frecuenciaCategorias); ?>,
              
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
        ,plugins: [bgColor]
    });
    const costoMaterialesCategorias = document.getElementById('costoMaterialesCategorias').getContext('2d');
    var ChartcostoMaterialesCategorias = new Chart(costoMaterialesCategorias, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_costoMaterialesCategorias); ?>,
            datasets: [{
                label: 'Categorias',
                data: <?php echo json_encode($cantidades_costoMaterialesCategorias); ?>,
                backgroundColor: <?php echo json_encode($colores_costoMaterialesCategorias); ?>,
              
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
        ,plugins: [bgColor]
    });
    const costoFuncionariosEjecutivosCategorias = document.getElementById('costoFuncionariosEjecutivosCategorias').getContext('2d');
    var ChartcostoFuncionariosEjecutivosCategorias = new Chart(costoFuncionariosEjecutivosCategorias, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_costoFuncionariosEjecutivosCategorias); ?>,
            datasets: [{
                label: 'Categorias',
                data: <?php echo json_encode($cantidades_costoFuncionariosEjecutivosCategorias); ?>,
                backgroundColor: <?php echo json_encode($colores_costoFuncionariosEjecutivosCategorias); ?>,
              
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
        ,plugins: [bgColor]
    });
    const costoTotalCategorias = document.getElementById('costoTotalCategorias').getContext('2d');
    var ChartcostoTotalCategorias = new Chart(costoTotalCategorias, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_costoTotalCategorias); ?>,
            datasets: [{
                label: 'Categorias',
                data: <?php echo json_encode($cantidades_costoTotalCategorias); ?>,
                backgroundColor: <?php echo json_encode($colores_costoTotalCategorias); ?>,
              
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
        ,plugins: [bgColor]
    });
    const frecuenciaOrdenesPorHoras = document.getElementById('frecuenciaOrdenesPorHoras').getContext('2d');
    var ChartfrecuenciaOrdenesPorHoras = new Chart(frecuenciaOrdenesPorHoras, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels_frecuenciaOrdenesPorHoras); ?>,
            datasets: [{
                label: 'Frecuencia',
                data: <?php echo json_encode($cantidades_frecuenciaOrdenesPorHoras); ?>,
                backgroundColor: <?php echo json_encode($colores_frecuenciaOrdenesPorHoras); ?>,
                fill: {
                target: 'origin',
                above: 'rgb(173,216,230)',   // Area will be red above the origin
                below: 'rgb(255, 0, 255)'    // And blue below the origin
                },
                borderWidth: 1,
                pointRadius: 5

            }]
        },
        options: {
              yAxes: {
                  ticks: {
                     stepSize: 1,
                  }
              }
        }
        
        ,plugins: [bgColor]
    });
    </script>



    
    <script>
    $(function(){
      $("#formOrdenes").css('background-color','#DAF7A6')
      $('#<?php echo $id; ?>').css('color','blue');
     
    })
    </script>


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

        $(document).ready(function() {
        $("#tablaOrdenes").fancyTable({
          inputPlaceholder: 'Buscar',
          inputStyle: 'color:black;',
          pagination: true,
          perPage: 6,
          sortable: true


        });	
        });
       
      
    </script>
    <script src="./js/generacionPDF.js"></script> 
</body>
</html>

<?php
    mysqli_close($conn);
?>