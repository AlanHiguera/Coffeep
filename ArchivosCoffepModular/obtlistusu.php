<?php
include 'conexion.php';

$usuarios_html = "";  // Asegúrate de definirlo aquí

// Query para obtener usuarios
$sql_check = "SELECT Usu_nickname, Usu_correo, Usu_nombre, Usu_apellido, Usu_edad FROM usuario ORDER BY Usu_nickname ASC;";
$result = $conn->query($sql_check);


// Generar el HTML con los resultados de la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios_html .= "<tr>";
        $usuarios_html .= "<td>" . htmlspecialchars($row['Usu_nickname']) . "</td>";
        $usuarios_html .= "<td>" . htmlspecialchars($row['Usu_correo']) . "</td>";
        $usuarios_html .= "<td>" . htmlspecialchars($row['Usu_nombre']) . "</td>";
        $usuarios_html .= "<td>" . htmlspecialchars($row['Usu_apellido']) . "</td>";
        $usuarios_html .= "<td>" . htmlspecialchars($row['Usu_edad']) . "</td>";
        $usuarios_html .= "<td><a href='#' class='delete-link'>Eliminar</a></td>";
        $usuarios_html .= "</tr>";
    }
} else {
    $usuarios_html = "<tr><td colspan='6'>No hay usuarios registrados</td></tr>";
}

$conn->close();
?>