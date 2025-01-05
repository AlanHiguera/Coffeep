<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

// Incluir el archivo de conexión
include 'conexion.php';

// Obtener datos del formulario
$nombre = $_POST["nombre"];

$sql_check = "SELECT Tip_nombre FROM tipo_ingrediente WHERE Tip_nombre = '$nombre'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "Error: El tipo ya existe.";
} else {
    // Insertar datos en la base de datos si no existe
    $sql_insert = "INSERT INTO tipo_ingrediente (Tip_nombre) 
                   VALUES ('$nombre')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Registro guardado correctamente.";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>