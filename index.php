<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";
    include "./recursos/funcionesConsultas.php";

    $DatosUsuario=ObtenerDatosBasicosUsuario();
    if(!isset($DatosUsuario['nombre'])){ header('Location: /administracionOrdenes/login.php'); exit();}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <?php libreriasCDN();?>
    
  <!-- Bootstrap -->
  <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
  
  <!-- Estilos NabBar -->
  <link rel="stylesheet" href="./css/navbar.css">

  <!-- Estilos index -->    
  <link rel="stylesheet" href="./css/index.css">

  <title>Inicio</title>

</head>
<body class="fondo-index">
  <header id="headerUser">
  <?php
        /* consultaDatosUsuario */
        if(isset($DatosUsuario['nombre'])){
            echo "<div> <i class='fa-solid fa-user'></i>";
            echo "<span>  Usuario: ".$DatosUsuario['nombre']." ".$DatosUsuario['apellido']."</span> </div>";
            OpcionCerrarSesion();
        }
  ?>
  </header>
  <!-- Barra de navegacion -->
  <div id="container-nav">
    <a href="./index.php" class="option-nav">
      <div id="container-option"> <i class="fa-solid fa-house" style="color:white"></i>Inicio </div>  
    </a>   
  
    <a href="./estadistica.php" class="option-nav">
      <div id="container-option"> <i class="fa-solid fa-chart-column" style="color:white"></i> Estadística</div>  
    </a>
  
    <a href="./ordenesTrabajo.php" class="option-nav">
      <div id="container-option"> <i class="fa-solid fa-list" style="color:white"></i>Ordenes de Trabajo </div>  
    </a>  
  </div>


  <div id="main">
    <div id="container-chart">
      
      <div id="chart">
        <button onclick="download_image('chart')" id="btnDescargar">Descargar</button>
      </div>
    
      <!-- consultas de datos ordenes -->
      <div id="info-chart">

        <div class="card-body cardDash cardDashboard">
        <?php obtenerTotalCosto();?> <img src="https://cdn-icons-png.flaticon.com/512/781/781902.png" alt="" width="45" height="45">
        </div>
              
        <div class="card-body cardDash cardDashboard">
        <?php obtenerTotalMateriales();?> <img src="https://cdn-icons-png.flaticon.com/512/3371/3371713.png" alt="" width="45" height="45">
        </div>
        
        <div class="card-body cardDash cardDashboard">
        <?php obtenerTotalFuncionarios();?> <img src="https://cdn-icons-png.flaticon.com/512/7424/7424725.png" alt="" width="45" height="45">
      
      </div>
    </div>
  </div>
      

<?php
  /* Consulta de los costos y fechas para el grafico principal */
  $costos=[];
  $fechas=[];
  $sql = "SELECT fechaAsignacion as fecha, costoTotal as costo FROM `ordenes` ORDER BY fecha";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
          array_push($costos, $row['costo']); array_push($fechas, $row['fecha']);
      }
  } else {
      echo "0 resultados";
  }
?>
<script>var costos = <?php echo json_encode($costos); ?>;
var fechas = <?php echo json_encode($fechas); ?>;</script>


<script>
/* opciones de grafico */
var options = {
  series: [{ name: "Costo de orden", data: costos }],
  chart: {type: 'area', height: 450, zoom: { enabled: true}, background: '#fff', width: '600px'},
  

  dataLabels: {enabled: false},
  forecastDataPoints: {count: 1},
  stroke: {curve: 'smooth', width: 5},
  
  title: {text: 'Grafico de costos', align: 'left'},
  subtitle: {text: 'CostoOrden vs Tiempo', align: 'left'},
  
  labels: fechas,
  xaxis: {type: 'datetime'}, yaxis: {opposite: true},
  legend: {horizontalAlign: 'left'}
};
/* renderizar grafico */
var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render(); 
</script>

<script>
/* descargar imagen del grafico principal */  
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