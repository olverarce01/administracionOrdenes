<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";
    include "./recursos/funcionesConsultas.php";
    $id=-1;
    $DatosUsuario=ObtenerDatosBasicosUsuario();
    if(!isset($DatosUsuario['nombre'])){
      header('Location: /administracionOrdenes/login.php');
      exit();
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


    <link rel="stylesheet" href="./css/navbar.css">
    <script src="./js/navbar.js"></script>

    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>
<body class="fondo-index">
    <header id="headerUser">
    <?php
        if(isset($DatosUsuario['nombre'])){
            echo "<div>";
            echo "<i class='fa-solid fa-user'></i>";
            echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span>";
            echo "</div>";
            OpcionCerrarSesion();
        }
    ?>
    </header>
    <div id="container-nav">
        <a href="./index.php" class="option-nav">
            <div id="container-option">
              <i class="fa-solid fa-house" style="color:white"></i>Inicio
            </div>  
        </a>
        
        <a href="./estadistica.php" class="option-nav">
          <div id="container-option">
            <i class="fa-solid fa-chart-column" style="color:white"></i>Estadística
          </div>  
        </a>
        <a href="./ordenesTrabajo.php" class="option-nav">
          <div id="container-option">
            <i class="fa-solid fa-list" style="color:white"></i>Ordenes de Trabajo
          </div>  
        </a>
    </div>


    <div id="main">
        <div id="container-chart">
            <div id="chart">
            <button onclick="download_image('chart')" id="btnDescargar">Descargar</button>

            </div>

            <div id="info-chart">
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
        </div>
      

    </div>
<?php
  $costos=[];
  $fechas=[];

  $sql = "SELECT fechaAsignacion as fecha, costoTotal as costo FROM `ordenes` ORDER BY fecha";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
          array_push($costos, $row['costo']);
          array_push($fechas, $row['fecha']);
      }
  } else {
      echo "0 resultados";
  }
?>
    <script>
      function padTo2Digits(num) {
      return num.toString().padStart(2, '0');
      }
      function formatDate(date) {
        return (
          [
            date.getFullYear(),
            padTo2Digits(date.getMonth() + 1),
            padTo2Digits(date.getDate()),
          ].join('-') +
          ' ' +
          [
            padTo2Digits(date.getHours()),
            padTo2Digits(date.getMinutes()),
            padTo2Digits(date.getSeconds()),
          ].join(':')
        );
      }
      function obtenerValorMaximo(costos){
        var Value = parseInt(costos[0],10);
        for(var i in costos){
        if(Value < parseInt(costos[i],10))
          Value = parseInt(costos[i],10);
        }
        return Value;
      }
      function normalizarCostos(costos){
        var costosNormalizados=[];
        for(var i in costos){
          costosNormalizados.push(parseInt(costos[i],10)/maxValue);
        }
        return costosNormalizados;
      }
      function obtenerUltimos3Costos(costosINT){
        var ultimosCostos = [];
        for (let index = costosINT.length-3; index < costosINT.length ; index++) {
          ultimosCostos.push(costosINT[index]);
        }
        return ultimosCostos
      }
      var costos = <?php echo json_encode($costos); ?>;
      var fechas = <?php echo json_encode($fechas); ?>;
      var maxValue = obtenerValorMaximo(costos);


      function realizarPrediccion(costos,fechas){
        maxValue = obtenerValorMaximo(costos);
        var costosINT = normalizarCostos(costos);      
        var ultimosCostos = obtenerUltimos3Costos(costosINT);
        
        var penultimaFecha = new Date(fechas[fechas.length-1]);
        var ultimaFecha = new Date(penultimaFecha.getTime() + (24 * 60 * 60 * 1000));
        /*Red neuronal*/
        var net = new brain.recurrent.LSTMTimeStep();
        net.train([
          costosINT
        ]);
        var resultado = net.run(ultimosCostos);
        costos.push(parseInt(resultado * maxValue,10).toString());
        fechas.push(formatDate(ultimaFecha));
      }
      realizarPrediccion(costos,fechas);
    </script>
    <script>
         var options = {
    series: [{
    name: "Costo de orden",
    data: costos
  }],
    chart: {
    type: 'area',
    height: 450,
    zoom: {
      enabled: true
    },
    background: '#fff',
    width: '600px'
  },
  dataLabels: {
    enabled: false
  },
  forecastDataPoints: {
          count: 1
  },
  stroke: {
    curve: 'smooth',
    width: 5
  },
  
  title: {
    text: 'Grafico de costos',
    align: 'left'
  },
  subtitle: {
    text: 'CostoOrden vs Tiempo',
    align: 'left'
  },
  labels: fechas,
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
    <script>
        function download_image(id){
          html2canvas(document.querySelector("#chart")).then(canvas => {
          image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
          var link = document.createElement('a');
          link.download = `${id}.png`;
          link.href = image;
          link.click();
        });

        
        }

     
    </script>
</body>
</html>