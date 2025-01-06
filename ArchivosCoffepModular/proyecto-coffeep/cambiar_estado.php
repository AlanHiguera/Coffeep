<?php
// Depuración de la sesión
// Conexión a la base de datos

session_start();
include "conexion.php";
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

// Recuperar el rol del usuario desde la sesión
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// Verificar si se ha proporcionado el nickname del usuario
if (isset($_GET['nickname'])) {
    $nickname = $_GET['nickname'];

    // Asegúrate de escapar las variables para evitar inyecciones SQL
    $nickname = $conn->real_escape_string($nickname);

    // Consulta para obtener el estado actual del usuario
    $sql = "SELECT Usu_estado FROM usuario WHERE Usu_nickname = '$nickname'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    if ($result) {
        // Verificar si se encontró el usuario
        if ($row = $result->fetch_assoc()) {
            $estado = $row['Usu_estado'];

            // Alternar el estado
            $nuevo_estado = ($estado === 'Activo') ? 'Inactivo' : 'Activo';

            // Consulta SQL para actualizar el estado del usuario
            $sql_update = "UPDATE usuario SET Usu_estado = '$nuevo_estado' WHERE Usu_nickname = '$nickname'";

            // Ejecutar la actualización
            if ($conn->query($sql_update)) {
                // Redirigir según el rol del usuario
                if ($rol === 'Administrador') {
                    header("Location: generar_listusu.php?msg=Estado cambiado a $nuevo_estado");
                } else {
                    header("Location: editar_perfil.php?msg=Estado cambiado a $nuevo_estado");
                }
                exit();
            } else {
                echo "Error al cambiar el estado del usuario: " . $conn->error;
            }
        } else {
            echo "Usuario no encontrado.";
        }
    } else {
        echo "Error al obtener el estado del usuario.";
    }
} else {
    echo "No se ha proporcionado el nickname del usuario.";
}

// Cerrar la conexión
$conn->close();
?>