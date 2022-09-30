<?php
$servername = "localhost";
$database = "administracionordenes";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
//echo "Conectado a la base de datos. ";
?>