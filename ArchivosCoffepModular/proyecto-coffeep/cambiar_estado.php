<?php
// Conexión a la base de datos
include "conexion.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}


// Verificar si se ha pasado el nickname del usuario
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
            if ($estado == 'activo') {
                $nuevo_estado = 'inactivo';
            } else {
                $nuevo_estado = 'activo';
            }

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
            } else {
                echo "Error al cambiar el estado del usuario.";
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
