<?php
// Conexión a la base de datos
include "conexion.php";

// Verificar si el formulario se envió (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores enviados desde el formulario
    $nickname = $_POST['nickname'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    // Asegurarse de que las variables estén limpias para evitar inyecciones SQL
    $nickname = $conn->real_escape_string($nickname);
    $nombre = $conn->real_escape_string($nombre);
    $apellido = $conn->real_escape_string($apellido);
    $correo = $conn->real_escape_string($correo);

    // Consulta SQL para actualizar los datos del usuario
    $sql_update = "UPDATE usuario SET Usu_nombre = '$nombre', Usu_apellido = '$apellido', Usu_correo = '$correo' WHERE Usu_nickname = '$nickname'";

    if ($conn->query($sql_update)) {
        // Redirigir con un mensaje de éxito
        header("Location: gestion_cuentas.php?msg=Datos actualizados correctamente.");
    } else {
        echo "Error al actualizar los datos.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
