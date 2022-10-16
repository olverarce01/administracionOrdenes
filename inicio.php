<?php
        include "./recursos/conexion.php";
        
        
        $user = !empty($_POST['correo']) ? $_POST['correo'] : 'correo';
        $password = !empty($_POST['pass']) ? $_POST['pass'] : 'pass';
        $buscar = "SELECT * FROM usuarios WHERE correo='$user' AND pass='$password'";
        $resultados = mysqli_query($conn , $buscar);
        $filas = mysqli_num_rows($resultados);
        if($filas > 0){
            session_start();
            $row = mysqli_fetch_assoc($resultados);
        
            $_SESSION['run'] = $row['run'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['pass'] = $row['pass'];
            $_SESSION['rol'] = $row['rol'];
                    
            $idSession = session_id();
            if($_SESSION['rol'] == 'Administrador')
            {
                header("Location: index.php"); 
            }
            else
            {
                header("Location: gestionGenerador.php"); 
            }
             
         }
        else{
            header("Location: login.php");
         }
        mysqli_free_result($resultados);
        mysqli_close($conn);
          
         
    ?>