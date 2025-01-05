<?php
include 'conexion.php';

function obtenerUsuarioUnico($conn) {
    // Verificar si el usuario está autenticado y tiene un ID/nickname en la sesión
    if (!isset($_SESSION['user'])) {
        return []; // Retorna un array vacío si no hay usuario autenticado
    }

    // Obtener el nickname del usuario desde la sesión
    $nickname = $conn->real_escape_string($_SESSION['user']); // Escapar el valor por seguridad

    // Consulta SQL para obtener los datos del usuario autenticado
    $sql_check = "SELECT Usu_nickname, Usu_correo, Usu_nombre, Usu_apellido, Usu_rol, Usu_estado 
                  FROM usuario 
                  WHERE Usu_nickname = '$nickname'";

    // Ejecutar la consulta
    $result = $conn->query($sql_check);

    // Verificar si se encontraron resultados
    if ($result && $result->num_rows > 0) {
        // Guardar el resultado en un array
        return $result->fetch_assoc(); // Solo un usuario, por lo que no es necesario un array de arrays
    } else {
        return []; // Retorna un array vacío si no hay resultados
    }
}
?>
