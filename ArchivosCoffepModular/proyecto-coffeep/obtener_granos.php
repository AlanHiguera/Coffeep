<?php
include 'conexion.php'; // Archivo de conexión a la base de datos

$granos = mysqli_query($conn, "SELECT Gra_idgrano, Gra_nombre FROM grano");
if ($granos) {
    while ($grano = mysqli_fetch_assoc($granos)) {
        echo '<option value="' . $grano['Gra_idgrano'] . '">' . $grano['Gra_nombre'] . '</option>';
    }
} else {
    echo '<option value="">Error al cargar los granos</option>';
}
?>