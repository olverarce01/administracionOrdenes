<?php
    function ObtenerDatosBasicosUsuario($rolUsuario){
        session_start();
        if(isset($_SESSION['nombre'])&&isset($_SESSION['apellido'])&&isset($_SESSION['run']) 
            && $rolUsuario == $_SESSION['rol']
        ){
            return $_SESSION;
        }
        return null;
    }
    function datosIncorrectos(){
        if(isset($_GET['error'])&& $_GET['error']=='datosIncorrectos'){
            echo '
            <div class="alert alert-danger text-center" role="alert">
                Datos incorrectos
            </div>
            ';
        }
    }
    function OpcionCerrarSesion(){
        echo '<form action="./recursos/cerrarsesion.php">
        <input type="submit" name="sesionDestroy" value="Cerrar sesion" class="btn btn-light"/>
        </form>
        ';
    }
    function libreriasCDN(){
        echo '
        <script src="//unpkg.com/brain.js"></script>
        <script src="https://kit.fontawesome.com/30cf8f014a.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.1/chart.min.js" integrity="sha512-ymysWHuTOgC1h8/MdSMcEyWmmjtfSh/7PYIDCZYIjW9sfS5Lfs5VBGbkPYZSM11L+JzJ3+id+gXDF4ImKcnxgA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.2.1/chartjs-plugin-zoom.min.js" integrity="sha512-klQv6lz2YR+MecyFYMFRuU2eAl8IPRo6zHnsc9n142TJuJHS8CG0ix4Oq9na9ceeg1u5EkBfZsFcV3U7J51iew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        
        ';
    }
?>