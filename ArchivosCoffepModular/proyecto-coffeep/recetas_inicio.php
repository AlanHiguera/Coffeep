<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include 'conexion.php';

// Obtener filtros seleccionados
$isRankingChecked = isset($_GET['ranking']) && $_GET['ranking'] == '1';
$selectedIngredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
$selectedGrainTypes = isset($_GET['grainTypes']) ? $_GET['grainTypes'] : [];
$selectedMethods = isset($_GET['methods']) ? $_GET['methods'] : [];

// Construir la consulta principal
$sql = "SELECT Rec_idrec, Rec_nombre, Rec_foto, Rec_calificacion, Rec_clasificacion, Rec_nickname 
        FROM receta";

// Añadir joins para ingredientes y tipos de grano si se seleccionan filtros
$joins = [];
$where = [];
$having = [];

// Filtro por ingredientes
if (!empty($selectedIngredients)) {
    $ingredientCount = count($selectedIngredients);
    $ingredientIds = implode(',', $selectedIngredients);
    $joins[] = "JOIN cantidad_ingrediente ON Rec_idrec = Can_idrec";
    $where[] = "Can_iding IN ($ingredientIds)";
    $having[] = "COUNT(DISTINCT Can_iding) = $ingredientCount";
}

// Filtro por tipos de grano
if (!empty($selectedGrainTypes)) {
    $grainTypeIds = implode(',', $selectedGrainTypes);
    $joins[] = "JOIN grano rg ON Rec_idgrano = Gra_idgrano";
    $where[] = "Gra_idgrano IN ($grainTypeIds)";
}

// Filtro por método
if (!empty($selectedMethods)) {
    $methods = "'" . implode("','", $selectedMethods) . "'";
    $where[] = "Rec_nombre IN ($methods)";
}

// Añadir joins y condiciones a la consulta
if (!empty($joins)) {
    $sql .= " " . implode(" ", $joins);
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Añadir cláusula HAVING si se filtró por ingredientes
if (!empty($having)) {
    $sql .= " GROUP BY Rec_idrec HAVING " . implode(" AND ", $having);
}

// Ordenar por ranking si se seleccionó
if ($isRankingChecked) {
    $sql .= " ORDER BY Rec_calificacion DESC";
}

// Ejecutar la consulta
$result = $conn->query($sql);
?>
