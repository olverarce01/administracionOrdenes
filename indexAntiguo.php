<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";
    include "./recursos/funcionesConsultas.php";
    $id=-1;
    $DatosUsuario=ObtenerDatosBasicosUsuario();
    if(isset($DatosUsuario['nombre'])){
      OpcionCerrarSesion();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    libreriasCDN();
    ?>
    <script src="multiselect-dropdown.js" ></script>
    <link rel="stylesheet" href="./flickity.css" media="screen">
    <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="./js/fancyTable.js"></script>
    <script src="./js/actualizarGrafico.js"></script> 
    <script src="./js/optionsGraficos.js"></script>
    <script src="./js/categorias.js"></script> 
    <script src="./js/selectsDinamicos.js"></script> 
    <script src="jquery/jquery-3.6.1.min.js"></script>
    <script src="./js/jquery.dataTables.min.js" defer></script>
    <link rel="stylesheet" href="./css/index.css">

    <title>AdministracionOrdenes</title>
</head>


<body class="fondo-index">



<div id="chart">
</div>

<div id="main-listaGraficos">
      <div>
        <div class="card-body cardDash cardDashboard">
              <?php obtenerTotalCosto();?>
              <img src="https://cdn-icons-png.flaticon.com/512/781/781902.png" alt="" width="45" height="45">
      </div>
    
      <div class="card-body cardDash cardDashboard">
              <?php obtenerTotalMateriales();?>        
              <img src="https://cdn-icons-png.flaticon.com/512/3371/3371713.png" alt="" width="45" height="45">
      </div>
      <div class="card-body cardDash cardDashboard">
              <?php obtenerTotalFuncionarios();?>        
              <img src="https://cdn-icons-png.flaticon.com/512/7424/7424725.png" alt="" width="45" height="45">
        </div>
    </div>

  <div id="formGrafico">
      <form action="">
        <input type='hidden' value='' name='porFecha'>
        <span>Seleccione un rango de tiempo a visualizar</span>
        <span>Segun Fecha de:</span>
        <select class="custom-select" id="fechaFiltro" name="fechaFiltro">
          <option selected="selected" value="fechaCreacion">Fecha de Creacion</option>
          <option value="fechaEdicion">Fecha de Edicion</option>
        </select>
        <div>
          <span>Desde: </span>
          <input type="date" name="dateInicio" id="dateInicio" aria-label="First name" value="<?php echo date('Y-m-d'); ?>">
          <input type="time" name="timeInicio" id="timeInicio" value="00:00">
        </div>
        <div>
          <span>Hasta: </span>
          <input type="date" name="dateFin" id="dateFin" aria-label="First name" value="<?php echo date('Y-m-d'); ?>">
          <input type="time" name="timeFin" id="timeFin" value="23:59">  
        </div>
        <button class="btn btn-danger" type="button" id="verCanvas">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
          <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
          <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
          </svg>
          Ver PDF
          </button>
          <button class="btn btn-danger" type="button" id="descargarCanvas">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
          <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
          <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
          </svg>
          Descargar PDF
          </button>            
      </form>
  </div>
  <div id="main-main-container-Graficos">
    <div class="main-gallery"  data-flickity-options='{ "cellAlign": "left", "contain": true }'>
        <div class="gallery-cell">
              <div class="container-Graficos"><canvas id="frecuenciaCategorias" class="grafico"></canvas></div>
        </div>
        <div class="gallery-cell">
              <div class="container-Graficos"><canvas id="costoMaterialesCategorias" class="grafico"></canvas></div>
        </div>
        <div class="gallery-cell">
              <div class="container-Graficos"><canvas id="costoFuncionariosEjecutivosCategorias" class="grafico"></canvas></div>
        </div>    
        <div class="gallery-cell">
              <div class="container-Graficos"><canvas id="frecuenciaOrdenesPorHoras" class="grafico"></canvas></div>
        </div>    
        <div class="gallery-cell">
              <div class="container-Graficos"><canvas id="costoTotalCategorias" class="grafico"></canvas></div>
        </div>    
    </div>
  </div>


</div>



<div id="main-infoOrdenes">
  <div id="tablaOrdenes">
      <table id="tablaO" class="table" cellspacing="0">
          <thead>
            <tr>
              <th class="th-sm">NºOrden</th>
              <th class="th-sm">Prioridad</th>
              <th class="th-sm">Tipo de trabajo</th>
              <th class="th-sm">Fecha de Asignacion</th>
              <th class="th-sm">Estado</th>
              <th class="th-sm">Accion</th>
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
                    echo "<td id='".$row["id"]."' class='tdOrdenes'>" . $row["fechaAsignacion"]. "</td>";
                    if($row["terminada"]==0){
                      echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-warning'>Pendiente</span></td>";
                      echo "<td><a href='./recursos/verOrden.php?ver=".$row["id"]."'><button class='btn btn-outline-secondary rounded'>Ver</button></a></td>";

                    }
                    else{
                      echo "<td id='".$row["id"]."' class='tdOrdenes'><span class='badge badge-success'>Terminada</span></td>";
                      echo "<td><a href='./recursos/verOrden.php?ver=".$row["id"]."'><button class='btn btn-outline-secondary rounded'>Ver</button></a></td> <br>";

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
  <div>
        <div class="card-body cardDash cardDashboard">
                <?php obtenerCantidadOrdenesTerminadas();?>
                <img src="https://cdn-icons-png.flaticon.com/512/8509/8509757.png" alt="" width="45" height="45">
        </div>
        <div class="card-body cardDash cardDashboard">
                <?php obtenerCantidadOrdenesNoTerminadas();?>
          <img src="https://cdn-icons-png.flaticon.com/512/8509/8509817.png" alt="" width="45" height="45">
        </div>
        <div class="card-body cardDash cardDashboard">
                <?php obtenerCantidadOrdenesAltaPrioridad();?>
          <img src="https://cdn-icons-png.flaticon.com/512/8509/8509757.png" alt="" width="45" height="45">
        </div>
  </div>
</div>

<?php    
    list($labels_frecuenciaCategorias,$cantidades_frecuenciaCategorias,$colores_frecuenciaCategorias) = obtenerDataGraficoFrecuenciaVSTipoOrden();
    list($labels_costoMaterialesCategorias,$cantidades_costoMaterialesCategorias,$colores_costoMaterialesCategorias) = obtenerDataGraficoCostoMaterialesVSTipoTrabajo();
    list($labels_costoFuncionariosEjecutivosCategorias, $cantidades_costoFuncionariosEjecutivosCategorias,$colores_costoFuncionariosEjecutivosCategorias) = obtenerDataGraficoCostoFuncionariosEjecutivosVSTipoTrabajo();
    list($labels_costoTotalCategorias, $cantidades_costoTotalCategorias,$colores_costoTotalCategorias) = obtenerDataGraficoCostoTotalVSTipoTrabajo();
    list($labels_frecuenciaOrdenesPorHoras, $cantidades_frecuenciaOrdenesPorHoras,$colores_frecuenciaOrdenesPorHoras) = obtenerDataGraficoFrecuenciaVSOrdenesPorHoras();
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
        options: optionsChartfrecuenciaCategorias
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
        options: optionsChartcostoMaterialesCategorias
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
        options: optionsChartcostoFuncionariosEjecutivosCategorias
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
        options: optionsChartcostoTotalCategorias
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
                above: 'rgba(173,216,230,0.4)',
                below: 'rgba(255, 0, 255,1)'
                },
                borderWidth: 1,
                pointRadius: 5

            }]
        },
        options: optionsChartfrecuenciaOrdenesPorHoras
        ,plugins: [bgColor]
    });
    </script>

    <script src="./flickity.pkgd.min.js"></script>


    
    <script>
    $(function(){
      $("#formOrdenes").css('background-color','#DAF7A6')
      $('#<?php echo $id; ?>').css('color','blue');
     
    })
    </script>
  
    
    <script src="./js/generacionPDF.js"></script> 

    <script>
      $('.main-gallery').flickity({
        // options
        cellAlign: 'left',
        contain: true,
        prevNextButtons: false,
        autoPlay: true
      });
      
    </script>
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

            } );
        }
        });
      });
    </script>

    <script>
         var options = {
    series: [{
    name: "STOCK ABC",
    data: [30,40,35,50]
  }],
    chart: {
    type: 'area',
    height: 350,
    zoom: {
      enabled: false
    },
    background: '#fff',
    width: '700px'
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  
  title: {
    text: 'Grafico de costos',
    align: 'left'
  },
  subtitle: {
    text: 'Costo de ordenes',
    align: 'left'
  },
  labels: ['2022-10-14 16:37:41',
           '2022-10-15 16:37:41',
           '2022-10-16 16:37:41',
           '2022-10-17 16:37:41'],
  xaxis: {
    type: 'datetime',
  },
  yaxis: {
    opposite: true
  },
  legend: {
    horizontalAlign: 'left'
  }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
      
    </script>
   
</body>
</html>

<?php
    mysqli_close($conn);
?>