<?php
include 'conexion.php'; // Archivo de conexión a la base de datos

$ingredientes = mysqli_query($conn, "SELECT Ing_iding, Ing_nombre FROM ingrediente");
if ($ingredientes) {
    while ($ingrediente = mysqli_fetch_assoc($ingredientes)) {
        echo '<option value="' . $ingrediente['Ing_iding'] . '">' . $ingrediente['Ing_nombre'] . '</option>';
    }
} else {
    echo '<option value="">Error al cargar los ingredientes</option>';
}
?>