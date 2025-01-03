<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

$ingredientes_query = "SELECT Ing_iding, Ing_nombre FROM coffe-p_ingrediente";
$ingredientes_result = $conn->query($ingredientes_query);

// Obtener granos
$granos_query = "SELECT Gra_idgrano, Gra_nombre FROM coffe-p_grano";
$granos_result = $conn->query($granos_query);

// Obtener nicknames
$nicknames_query = "SELECT DISTINCT Rec_nickname FROM coffe-p_receta";
$nicknames_result = $conn->query($nicknames_query);
// Inicializar variables de filtro
$ingrediente = isset($_GET['ingrediente']) ? $_GET['ingrediente'] : null;
$grano = isset($_GET['grano']) ? $_GET['grano'] : null;
$nickname = isset($_GET['nickname']) ? $_GET['nickname'] : null;

// Construir la consulta con filtros dinámicos
$query = "
  SELECT DISTINCT R.*
  FROM receta R
  LEFT JOIN cantidad_ingrediente CI ON R.Rec_idrec = CI.Can_idrec
  LEFT JOIN ingrediente I ON CI.Can_iding = I.Ing_iding
  LEFT JOIN grano G ON R.Rec_idgrano = G.Gra_idgrano
  WHERE 1 = 1
";

if ($ingrediente) {
    $query .= " AND I.Ing_iding = $ingrediente";
}
if ($grano) {
    $query .= " AND G.Gra_idgrano = $grano";
}
if ($nickname) {
    $query .= " AND R.Rec_nickname = '$nickname'";
}

// Ejecutar la consulta
$result = $conn->query($query);

// Verificar si hubo errores en la consulta (opcional)
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>