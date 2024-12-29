<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}
include 'conexion.php'; // Incluye la conexión a la base de datos

if (isset($_GET['id'])) {
    // Validar y convertir el ID a un número entero
    $id = intval($_GET['id']);

    // Crear la consulta SQL directamente
    $sql = "DELETE FROM tipo_ingrediente WHERE Tip_idtipo = $id";

    if ($conn->query($sql) === TRUE) {
        // Si la eliminación es exitosa, redirige al usuario a la página original
        header("Location: mantenedor_ting.php");
        exit;
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}
?>
