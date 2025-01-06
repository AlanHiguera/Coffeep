<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    // Consulta clásica para actualizar el nombre
    $sql_update = "UPDATE tipo_ingrediente SET Tip_nombre = '$nombre' WHERE Tip_idtipo = $id";

    if (mysqli_query($conn, $sql_update)) {
        echo "Exitoso: El nombre ha sido actualizado.";
    } else {
        echo "Error al actualizar: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
