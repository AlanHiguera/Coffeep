<?php
// Parámetros de conexión a la base de datos
$host = "localhost";
$user = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL
$database = "coffe-p"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Error (conexion fallida): " . $conn->connect_error);
}

?>