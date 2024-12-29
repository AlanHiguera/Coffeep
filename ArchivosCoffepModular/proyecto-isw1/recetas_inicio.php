<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se seleccionó el filtro de ranking
$isRankingChecked = isset($_GET['ranking']) && $_GET['ranking'] == '1';

// Construir la consulta SQL según el filtro
if ($isRankingChecked) {
    $sql = "SELECT Rec_nombre, Rec_foto, Rec_calificacion, Rec_clasificacion FROM Receta ORDER BY Rec_calificacion DESC LIMIT 10";
} else {
    $sql = "SELECT Rec_nombre, Rec_foto, Rec_calificacion, Rec_clasificacion FROM Receta";
}

$result = $conn->query($sql);
?>