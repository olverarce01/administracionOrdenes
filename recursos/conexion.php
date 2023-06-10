<?php

$mysql_url = 'mysql://root:6x0YIOvKZKgAI8rLSIuQ@containers-us-west-3.railway.app:7590/railway';
$database = 'railway';
$host = 'containers-us-west-3.railway.app';
$password = '6x0YIOvKZKgAI8rLSIuQ';
$port = '7590';
$user = 'root';

// Crear conexión
$conn = mysqli_connect($host, $user, $password, $database, $port);

// Verificar la conexión
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
//echo "Conectado a la base de datos. ";
?>