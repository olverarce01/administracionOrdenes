<?php
include "./recursos/conexion.php";
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
    
    <div class="main">
        <div class="form-signin mx-auto mt-5 pt-5 pb-5 form-login" style="width: 400px; height: 500px;">
            <!-- formulario -->
            <form class="form-signin tamaño-form-login mx-auto" action="inicio.php" method="POST">
            
                <div class="text-center mb-4">
                    <img class="mb-4" src="./img/utaHorizontal.png" alt="" width="213" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesion</h1>
                    
                </div>
            
                <div class="form-label-group">
                    <input type="correo" id="inputCorreo" class="form-control" placeholder="Direccion correo" required="" autofocus="" name="correo">
                    <label for="inputCorreo">Direccion de correo</label>
                </div>
            
                <div class="form-label-group">
                    <input type="pass" id="inputContraseña" class="form-control" placeholder="Contraseña" required="" name="pass">
                    <label for="inputContraseña">Contraseña</label>
                </div>
                <!-- pediente -->
                <!-- <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Acceso al sistema de Administrativo.
                    </label>
                </div> -->
                <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
            
            </form>
        </div>
        
    </div>
    <footer class="mt-5 py-5  text-muted text-center text-small bg-light">
        <p class="mb-1 color-texto">Universidad de Tarapacá – Universidad del Estado de Chile</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacidad</a></li>
            <li class="list-inline-item"><a href="#">Terminos</a></li>
            <li class="list-inline-item"><a href="#">Soporte</a></li>
        </ul>
    </footer>
</div>
</body>
</html>