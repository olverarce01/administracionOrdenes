<?php
include "./recursos/conexion.php";
include "./recursos/funcionesLogin.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link Type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" rel="stylesheet" href="./css/estilos.css">
    <!--     estilos bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jquery/jquery-3.6.1.min.js"></script>
</head>
<body>

<div class="fondo">
    <header>
      <nav class="navbar navbar-light bg-light">
        <!-- Logo UTA -->
        <a class="navbar-brand" href="#">
          <img src="./img/utaHorizontal.png" width="300" height="80" class="d-inline-block align-top" alt="Logo Uta">
        </a>
      </nav>
    </header>
    <?php
    datosIncorrectos();
    ?>
    <div class="main">
        <div class="form-signin mx-auto mt-5 pt-5 pb-5 form-login" style="width: 400px; height: 500px;">
            <!-- formulario -->
            <form class="form-signin tamaño-form-login mx-auto" action="inicio.php" method="POST">
            
                <div class="text-center mb-4">
                    <img class="mb-4" src="./img/utaHorizontal.png" alt="" width="213" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>
                    <p>Ordenes de trabajo</p>
                    
                </div>
            
                <div class="form-label-group">
                    <label for="inputCorreo">Dirección de correo</label>
                    <input type="email" id="inputCorreo" class="form-control" placeholder="Direccion correo" required="" autofocus="" name="correo">
                </div>
            
                <div class="form-label-group">
                    <label for="inputContraseña">Contraseña</label>
                    <input type="password" id="inputContraseña" class="form-control" placeholder="Contraseña" required="" name="pass">
                </div>
                <div class="form-label-group">
                    <label for="inputContraseña">Soy:<span>   </span><input type="radio" name="rol" value="generador" required/> Generador <span> | </span> <input type="radio" name="rol" value="Administrador"/></label> Personal Interno</label>
                    
                </div>

                <button class="btn btn-lg btn-primary btn-block my-2" type="submit">Iniciar sesión</button>
            
            </form>
        </div>
        
    </div>
    <footer class="mt-5 py-5  text-muted text-center text-small bg-light">
        <p class="mb-1 color-texto text-white">Universidad de Tarapacá – Universidad del Estado de Chile</p>
    </footer>
</div>
</body>
</html>