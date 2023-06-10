<?php 
    include "./recursos/conexion.php";   
    include "./recursos/funcionesLogin.php";
    include "./recursos/funcionesConsultas.php";
    $DatosUsuario=ObtenerDatosBasicosUsuario('Administrador');
    
    if(!isset($DatosUsuario['nombre'])){header('Location: /administracionOrdenes/login.php'); exit();}

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php libreriasCDN(); ?>


    <link rel="stylesheet" href="./flickity.css" media="screen">
    
     <!-- bootstrap -->
    <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- funciones graficos -->
    <script src="./js/actualizarGrafico.js"></script> 
    <script src="./js/optionsGraficos.js"></script>
    <!-- jquery -->
    <script src="jquery/jquery-3.6.1.min.js"></script>
    <script src="./js/jquery.dataTables.min.js" defer></script>
    <!-- estilos barra navegacion -->
    <link rel="stylesheet" href="./css/navbar.css">
    <script src="./js/navbar.js"></script>
    <!-- estilos index -->
    <link rel="stylesheet" href="./css/index.css">
    <title>Estadística</title>
</head>
<body class="fondo-index">
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
    <!-- barra de navegacion -->
    <div id="container-nav">
        <a href="./index.php" class="option-nav">
            <div id="container-option"> <i class="fa-solid fa-house" style="color:black"></i>Inicio </div>  
        </a>
        
        <a href="./estadistica.php" class="option-nav">
          <div id="container-option"> <i class="fa-solid fa-chart-column" style="color:#374da5"></i>Estadística </div>  
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


    <div id="main">
            <div id="container-graficos">
                    <!-- formulario filtros grafico -->

                    <div id="formGrafico">
                        <form action="" class="form alert alert-info mx-2">
                            <div class="mx-2">
                                <input type='hidden' value='' name='porFecha'>
                                <span>Tipo de fecha:
                                    <select class="custom-select" id="fechaFiltro" name="fechaFiltro" style="width: 200px;">
                                        <option selected="selected" value="fechaCreacion">Fecha de Creacion</option>
                                        <option value="fechaEdicion">Fecha de Edicion</option>
                                        <option value="fechaAsignacion">Fecha de Asignacion</option>
                                    </select>
                                </span>   
                            </div> 

                            <div class="mx-2">
                                <div>
                                    <span>Desde: </span>
                                    <div>
                                        <input type="date" name="dateInicio" id="dateInicio" aria-label="First name" value="<?php echo date('Y-m-d', strtotime("- 1 month")); ?>">
                                        <input type="time" name="timeInicio" id="timeInicio" value="00:00">
                                    </div>
                                </div>
                            </div>

                            <div>
                            <div>
                                    <span>Hasta: </span>
                                    <div>
                                        <input type="date" name="dateFin" id="dateFin" aria-label="First name" value="<?php echo date('Y-m-d'); ?>">
                                        <input type="time" name="timeFin" id="timeFin" value="23:59">
                                    </div> 
                                </div>    
                            </div>

                            <div class="mx-2">
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
                                
                                <button class="btn btn-success" type="button" id="descargarCSV">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" width="16" height="16" x="0px" y="0px"
                                    viewBox="0 0 48 48" style="enable-background:new 0 0 48 48;" xml:space="preserve">
                                    <g>
                                    <g>
                                    <path d="M47.987,21.938c-0.006-0.091-0.023-0.178-0.053-0.264c-0.011-0.032-0.019-0.063-0.033-0.094
                                        c-0.048-0.104-0.109-0.202-0.193-0.285c-0.001-0.001-0.001-0.001-0.001-0.001L42,15.586V10c0-0.022-0.011-0.041-0.013-0.063
                                        c-0.006-0.088-0.023-0.173-0.051-0.257c-0.011-0.032-0.019-0.063-0.034-0.094c-0.049-0.106-0.11-0.207-0.196-0.293l-9-9
                                        c-0.086-0.086-0.187-0.148-0.294-0.196c-0.03-0.014-0.06-0.022-0.091-0.032c-0.085-0.03-0.172-0.047-0.263-0.052
                                        C32.039,0.01,32.021,0,32,0H7C6.448,0,6,0.448,6,1v14.586l-5.707,5.707c0,0-0.001,0.001-0.002,0.002
                                        c-0.084,0.084-0.144,0.182-0.192,0.285c-0.014,0.031-0.022,0.062-0.033,0.094c-0.03,0.086-0.048,0.173-0.053,0.264
                                        C0.011,21.96,0,21.978,0,22v19c0,0.552,0.448,1,1,1h5v5c0,0.552,0.448,1,1,1h34c0.552,0,1-0.448,1-1v-5h5c0.552,0,1-0.448,1-1V22
                                        C48,21.978,47.989,21.96,47.987,21.938z M44.586,21H42v-2.586L44.586,21z M38.586,9H33V3.414L38.586,9z M8,2h23v8
                                        c0,0.552,0.448,1,1,1h8v5v5H8v-5V2z M6,18.414V21H3.414L6,18.414z M40,46H8v-4h32V46z M46,40H2V23h5h34h5V40z"/>
                                    <path d="M23.422,27.885c0.147-0.136,0.312-0.235,0.493-0.298c0.181-0.062,0.368-0.093,0.561-0.093
                                        c0.669,0,1.224,0.266,1.666,0.799l1.122-1.462c-0.329-0.385-0.734-0.677-1.215-0.876c-0.482-0.198-1.028-0.297-1.64-0.297
                                        c-0.419,0-0.833,0.071-1.241,0.212c-0.408,0.142-0.774,0.36-1.097,0.655c-0.323,0.295-0.584,0.666-0.782,1.113
                                        c-0.198,0.448-0.298,0.984-0.298,1.607c0,0.499,0.065,0.926,0.195,1.283c0.13,0.358,0.306,0.669,0.527,0.935
                                        c0.221,0.267,0.476,0.496,0.765,0.689c0.289,0.193,0.598,0.368,0.927,0.527c0.521,0.261,0.952,0.544,1.292,0.85
                                        c0.34,0.306,0.51,0.72,0.51,1.241c0,0.533-0.142,0.946-0.425,1.241s-0.64,0.442-1.071,0.442c-0.385,0-0.762-0.091-1.131-0.272
                                        s-0.683-0.431-0.944-0.748l-1.105,1.496c0.34,0.397,0.793,0.725,1.36,0.986c0.567,0.261,1.184,0.391,1.853,0.391
                                        c0.465,0,0.907-0.079,1.326-0.238c0.419-0.159,0.785-0.394,1.097-0.706c0.312-0.311,0.561-0.694,0.748-1.147
                                        c0.187-0.453,0.281-0.975,0.281-1.564c0-0.51-0.079-0.952-0.238-1.326c-0.159-0.374-0.363-0.697-0.612-0.969
                                        c-0.249-0.272-0.527-0.504-0.833-0.697c-0.306-0.193-0.606-0.363-0.901-0.51c-0.499-0.249-0.901-0.513-1.207-0.791
                                        c-0.306-0.277-0.459-0.671-0.459-1.181c0-0.295,0.042-0.55,0.128-0.765C23.159,28.197,23.275,28.021,23.422,27.885z"/>
                                    <path d="M15.177,28.854c0.204-0.397,0.459-0.711,0.765-0.944c0.306-0.232,0.663-0.348,1.071-0.348
                                        c0.737,0,1.337,0.334,1.802,1.003l1.173-1.428c-0.329-0.476-0.754-0.841-1.275-1.097c-0.521-0.255-1.128-0.382-1.819-0.382
                                        c-0.669,0-1.278,0.156-1.828,0.467c-0.55,0.312-1.017,0.748-1.403,1.309c-0.385,0.562-0.683,1.23-0.892,2.006
                                        c-0.21,0.777-0.314,1.624-0.314,2.542c0,0.918,0.105,1.762,0.314,2.533s0.504,1.436,0.884,1.997
                                        c0.38,0.562,0.844,1.001,1.394,1.318s1.165,0.476,1.845,0.476c0.748,0,1.368-0.147,1.861-0.442s0.898-0.68,1.215-1.156
                                        l-1.173-1.377c-0.193,0.295-0.434,0.544-0.722,0.748s-0.632,0.306-1.028,0.306c-0.419,0-0.785-0.116-1.097-0.349
                                        c-0.312-0.232-0.569-0.546-0.774-0.943s-0.357-0.864-0.459-1.403c-0.102-0.538-0.153-1.107-0.153-1.708
                                        c0-0.612,0.051-1.187,0.153-1.726C14.82,29.718,14.973,29.251,15.177,28.854z"/>
                                    <polygon points="32.007,35.62 31.956,35.62 29.95,25.964 27.672,25.964 30.613,38 33.197,38 36.189,25.964 34.013,25.964 		"/>
                                        </g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    </svg>
                                    Descargar CSV
                                </button>
                            </div>
                                
                        </form>
                    </div>
            </div>
            <!-- contenedor grafico -->
            <div id="main-main-container-Graficos">
                <div class="main-gallery"  data-flickity-options='{ "cellAlign": "left", "contain": true }'>
                    <div class="gallery-cell">
                        <div class="container-Graficos"><canvas id="frecuenciaCategorias" class="grafico"></canvas>
                        <button onclick="download_image('frecuenciaCategorias')">Descargar</button>
                        </div>
                    </div>

                    <div class="gallery-cell">
                        <div class="container-Graficos"><canvas id="costoMaterialesCategorias" class="grafico"></canvas>
                        <button onclick="download_image('costoMaterialesCategorias')">Descargar</button>
                        </div>
                    </div>

                    <div class="gallery-cell">
                        <div class="container-Graficos"><canvas id="costoFuncionariosEjecutivosCategorias" class="grafico"></canvas>
                        <button onclick="download_image('costoFuncionariosEjecutivosCategorias')">Descargar</button>                    
                        </div>
                    </div>    

                    <div class="gallery-cell">
                        <div class="container-Graficos"><canvas id="costoTotalCategorias" class="grafico"></canvas>
                        <button onclick="download_image('costoTotalCategorias')">Descargar</button>                                                            
                        </div>
                    </div>  

                    <div class="gallery-cell">
                        <div class="container-Graficos"><canvas id="frecuenciaOrdenesPorHoras" class="grafico"></canvas>
                        <button onclick="download_image('frecuenciaOrdenesPorHoras')">Descargar</button>                                        
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="mt-5 py-5  text-muted text-center text-small">
  <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
</footer>
<?php    
    /* data para graficos */
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
$('.main-gallery').flickity({
// options
    cellAlign: 'left',
    contain: true,
    prevNextButtons: false,
    autoPlay: true
});   
   
</script>

<script>
function download_image(Ncanvas){
    var canvas = document.getElementById(Ncanvas);
    image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
    var link = document.createElement('a');
    link.download = `${Ncanvas}.png`;
    link.href = image;
    link.click();
}
</script>

<script>
    function arrayObjToCsv(ar) {
	//comprobamos compatibilidad
	if(window.Blob && (window.URL || window.webkitURL)){
		var contenido = "",
			d = new Date(),
			blob,
			reader,
			save,
			clicEvent;
		//creamos contenido del archivo
		for (var i = 0; i < ar.length; i++) {
			//construimos cabecera del csv
			if (i == 0)
				contenido += Object.keys(ar[i]).join(";") + "\n";
			//resto del contenido
			contenido += Object.keys(ar[i]).map(function(key){
							return ar[i][key];
						}).join(";") + "\n";
		}
		//creamos el blob
		blob =  new Blob(["\ufeff", contenido], {type: 'text/csv'});
		//creamos el reader
		var reader = new FileReader();
		reader.onload = function (event) {
			//escuchamos su evento load y creamos un enlace en dom
			save = document.createElement('a');
			save.href = event.target.result;
			save.target = '_blank';
			//aquí le damos nombre al archivo
			save.download = "OrdenesTrabajo"+ d.getDate() + "_" + (d.getMonth()+1) + "_" + d.getFullYear() +".csv";
			try {
				//creamos un evento click
				clicEvent = new MouseEvent('click', {
					'view': window,
					'bubbles': true,
					'cancelable': true
				});
			} catch (e) {
				//si llega aquí es que probablemente implemente la forma antigua de crear un enlace
				clicEvent = document.createEvent("MouseEvent");
				clicEvent.initEvent('click', true, true);
			}
			//disparamos el evento
			save.dispatchEvent(clicEvent);
			//liberamos el objeto window.URL
			(window.URL || window.webkitURL).revokeObjectURL(save.href);
		}
		//leemos como url
		reader.readAsDataURL(blob);
	}else {
		//el navegador no admite esta opción
		alert("Su navegador no permite esta acción");
	}
    };

    $('#verCanvas').click(function(){
  
    window.open(`/recursos/ordenesDataReporte.php?
        reporte=ver&
        dateInicio=${$('#dateInicio').val()}&
        dateFin=${$('#dateFin').val()}&
        timeInicio=${$('#timeInicio').val()}&
        timeFin=${$('#timeFin').val()}&
        fechaFiltro=${$('#fechaFiltro').val()}
        `);


    })
    $('#descargarCanvas').click(function(){
   

    window.location.href = `/recursos/ordenesDataReporte.php?
        reporte=descargar&
        dateInicio=${$('#dateInicio').val()}&
        dateFin=${$('#dateFin').val()}&
        timeInicio=${$('#timeInicio').val()}&
        timeFin=${$('#timeFin').val()}&
        fechaFiltro=${$('#fechaFiltro').val()}
        `;
    })   


$(function(){
    $('#descargarCSV').click(
    function(){
        $.get(`./recursos/rangoFechas.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
            var miArrayDeObjetos=JSON.parse(mensaje);
            console.log(miArrayDeObjetos)
            arrayObjToCsv(miArrayDeObjetos);  
        });
    });

});
</script>

</body>
</html>

