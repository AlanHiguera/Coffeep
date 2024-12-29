<?php
include 'conexion.php';

function obtenerUsuarios($conn) {
    // Consulta SQL para obtener los usuarios
    $sql_check = "SELECT Usu_nickname, Usu_correo, Usu_nombre, Usu_apellido, Usu_rol FROM usuario";
    
    // Ejecutar la consulta
    $result = $conn->query($sql_check);
    
    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Guardar los resultados en un array
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    } else {
        return []; // Retorna un array vacío si no hay resultados
    }
}
?>