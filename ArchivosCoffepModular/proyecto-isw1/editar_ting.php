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

    if (empty($id) || empty($nombre)) {
        echo "Error: Datos incompletos.";
        exit;
    }

    $sql_update = "UPDATE tipo_ingrediente SET Tip_nombre = ? WHERE Tip_idtipo = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            echo "Exitoso: El nombre ha sido actualizado.";
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    $conn->close();
}
?>
