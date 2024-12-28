<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    // Verifica que los datos no estén vacíos
    if (empty($id) || empty($nombre)) {
        echo "Error: Datos incompletos.";
        exit;
    }

    // Escapa las variables para evitar inyecciones SQL
    $id = intval($id); // Asegúrate de que $id sea un número entero
    $nombre = $conn->real_escape_string($nombre); // Escapa caracteres especiales en $nombre

    // Construye la consulta SQL directamente
    $sql_update = "UPDATE tipo_ingrediente SET Tip_nombre = '$nombre' WHERE Tip_idtipo = $id";

    // Ejecuta la consulta
    if ($conn->query($sql_update) === TRUE) {
        echo "Exitoso: El nombre ha sido actualizado.";
    } else {
        echo "Error al actualizar: " . $conn->error;
    }

    $conn->close();
}
?>
