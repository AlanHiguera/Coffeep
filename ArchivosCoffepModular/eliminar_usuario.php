<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

// Imprime todos los valores recibidos por GET para verificar
var_dump($_GET);

if (isset($_GET['nickname'])) {
    $nickname = $_GET['nickname']; // Obtiene el parámetro directamente sin sanitizar

    $sql = "DELETE FROM usuario WHERE Usu_nickname = '$nickname'";
    $stmt = $conn->prepare($sql);

     if ($stmt) {
        if ($stmt->execute()) {
            // Si la eliminación es exitosa, redirige al usuario a la página original
            header("Location: mantenedortusu.php");
            exit;
        } else {
             echo "Error al eliminar el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}

?>