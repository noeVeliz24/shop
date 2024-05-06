<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "aeropuerto2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
