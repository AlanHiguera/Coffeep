<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Incluye la conexión a la base de datos

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegúrate de que el ID sea un número entero

    // Prepara la consulta SQL para eliminar el registro
    $sql = "DELETE FROM tipo_ingrediente WHERE Tip_idtipo = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Si la eliminación es exitosa, redirige al usuario a la página original
            header("Location: mantenedor_ting.php");
            exit;
        } else {
            echo "Error al eliminar el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}