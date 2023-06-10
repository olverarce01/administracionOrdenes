<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";
    include "./recursos/funcionesConsultas.php";

    $DatosUsuario=ObtenerDatosBasicosUsuario('Administrador');


    if(!isset($DatosUsuario['nombre'])){ 
        header('Location: login.php'); exit();
    }

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
  <header>
    <nav class="navbar">
      <!-- Logo UTA -->
      <a class="navbar-brand" href="#">
        <img src="./img/utaHorizontal.png" width="300" height="80" class="d-inline-block align-top" alt="Logo Uta">
      </a>
      <a><?php obtenerTotalCosto();?></a>
      <a><?php obtenerTotalMateriales();?></a>
      <a><?php obtenerTotalFuncionarios();?></a>       
     
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
    <!-- Barra de navegacion -->
    <div id="container-nav">
      <a href="./index.php" class="option-nav">
        <div id="container-option"> <i class="fa-solid fa-house" style="color:#374da5"></i>Inicio </div>  
      </a>   
    
      <a href="./estadistica.php" class="option-nav">
        <div id="container-option"> <i class="fa-solid fa-chart-column" style="color:black"></i> Estadística</div>  
      </a>
    
      <a href="./ordenesTrabajo.php" class="option-nav">
        <div id="container-option"> <i class="fa-solid fa-list" style="color:black"></i>Ordenes de Trabajo </div>  
      </a>  

      <a href="./funcionarios.php" class="option-nav">
        <div id="container-option"> <i class="fa-solid fa-user-group" style="color:black"></i> Funcionarios </div>  
      </a>  

      <a href="./materiales.php" class="option-nav">
        <div id="container-option"> <i class="fa-solid fa-screwdriver-wrench" style="color:black"></i> Materiales </div>  
      </a>  

    </div>
          <!-- Main -->
    <div id="main">
      <div id="container-chart">
        <div id="chart">
        </div>
      </div>
      <div id="centrarBtn">
        <button onclick="download_image('chart')" id="btnDescargar" class="mx-auto">Descargar</button>    
      </div>
    </div>
  </div>
      
<footer class="mt-5 py-5  text-muted text-center text-small">
  <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
</footer>
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
  chart: {
          type: 'area', 
          height: 490, 
          zoom: { enabled: true}, 
          background: '#fff', 
          width: '1150px',
  },

  dataLabels: {enabled: false},
  stroke: {curve: 'straight', width: 5},
  
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
  $("#btnDescargar").toggle();
  html2canvas(document.querySelector("#chart")).then(canvas => {
  image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
  var link = document.createElement('a');
  link.download = `${id}.png`;
  link.href = image;
  link.click();
  });        
  $("#btnDescargar").toggle();
}
</script>

</body>
</html>