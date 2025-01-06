<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include 'conexion.php';

// Obtener el ID del usuario logueado desde la sesión
$userId = $_SESSION['user']; // Asegúrate de que el ID del usuario está almacenado en la sesión

// Obtener filtros seleccionados
$isRankingChecked = isset($_GET['ranking']) && $_GET['ranking'] == '1';
$selectedIngredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
$selectedGrainTypes = isset($_GET['grainTypes']) ? $_GET['grainTypes'] : [];
$selectedMethods = isset($_GET['methods']) ? $_GET['methods'] : [];
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Construir la consulta principal
$sql = "SELECT Rec_idrec, Rec_nombre, Rec_foto, Rec_calificacion, Rec_clasificacion, Rec_nickname 
        FROM receta 
        JOIN guardado ON Rec_idrec = Gua_idrec
        WHERE Gua_nickname = '$userId'";

// Añadir filtros adicionales
$where = [];
$having = [];

// Filtro por ingredientes
if (!empty($selectedIngredients)) {
    $ingredientCount = count($selectedIngredients);
    $ingredientIds = implode(',', $selectedIngredients);
    $sql .= " JOIN cantidad_ingrediente ON Rec_idrec = Can_idrec";
    $where[] = "Can_iding IN ($ingredientIds)";
    $having[] = "COUNT(DISTINCT Can_iding) = $ingredientCount";
}

// Filtro por tipos de grano
if (!empty($selectedGrainTypes)) {
    $grainTypeIds = implode(',', $selectedGrainTypes);
    $sql .= " JOIN grano ON Rec_idgrano = Gra_idgrano";
    $where[] = "Gra_idgrano IN ($grainTypeIds)";
}

// Filtro por método
if (!empty($selectedMethods)) {
    $methods = "'" . implode("','", $selectedMethods) . "'";
    $where[] = "Rec_metodo IN ($methods)";
}

// Filtro por búsqueda de nombre
if (!empty($search)) {
    // Normaliza el texto a minúsculas para que no sea sensible a mayúsculas
    $search = strtolower($conn->real_escape_string($search));
    $where[] = "LOWER(Rec_nombre) LIKE '%$search%'";
}

// Añadir condiciones WHERE si hay filtros
if (!empty($where)) {
    $sql .= " AND " . implode(" AND ", $where);
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


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis recetas - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="inicio.css">
  <link rel="icon" href="images/favicon.png">
</head>
<body>
<!-- Encabezado -->
<header>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="guia.php">Información</a></li>
        </ul>
        <div class="icons">
            <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></span>
            <?php 
            if (isset($_SESSION['user'])): 
                // Verificar el rol y ajustar el enlace
                if (isset($_SESSION['rol']) && trim($_SESSION['rol']) === 'Administrador'): ?>
                    <a href="perfil_admin.php">
                        <img src="images/user.png" alt="Perfil Admin" style="width: 40px; height: 40px;">
                    </a>
                <?php else: ?>
                    <a href="miperfil.php">
                        <img src="images/user.png" alt="Mi Perfil" style="width: 40px; height: 40px;">
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="registro.php">
                    <img src="images/user.png" alt="Registrarse" style="width: 40px; height: 40px;">
                </a>
            <?php endif; ?>
            </span>
        </div>
    </nav>
  </header>

  <!-- Contenido principal -->
  <main>
    <div class="container">
        <!-- Contenedor de Filtros -->
        <div class="filters-container">
            <form method="GET" action="">
                <!-- Barra de búsqueda -->
                <div class="search-bar">
                    <input type="text" name="search" placeholder="Buscar receta..." value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES) ?>">
                    <button type="submit"><b>Buscar</b></button>
                </div>
                <div class="filters">
                    <h3>Filtros por categoría</h3>
                    
                    <!-- Filtro Ranking -->
                    <div class="filter-group">
                        <label>
                            <input type="checkbox" name="ranking" value="1" <?php if (isset($_GET['ranking'])) echo 'checked'; ?>>
                            <span>Ranking</span>
                        </label>
                    </div>
                    
                    <!-- Filtro por Ingredientes -->
                    <div class="filter-group">
                        <label>
                            <input type="checkbox" onclick="toggleFilter('ingredients-options')" />
                            <span>Ingredientes</span>
                        </label>
                        <div id="ingredients-options" class="filter-options">
                            <?php
                            $ingredientes = $conn->query("SELECT Ing_iding, Ing_nombre FROM ingrediente");
                            while ($row = $ingredientes->fetch_assoc()) {
                                $checked = isset($_GET['ingredients']) && in_array($row['Ing_iding'], $_GET['ingredients']) ? 'checked' : '';
                                echo "
                                    <label>
                                        <input type='checkbox' name='ingredients[]' value='{$row['Ing_iding']}' $checked>
                                        <span>{$row['Ing_nombre']}</span>
                                    </label>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Filtro por Tipos de Grano -->
                    <div class="filter-group">
                        <label>
                            <input type="checkbox" onclick="toggleFilter('grain-options')" />
                            <span>Tipos de Grano</span>
                        </label>
                        <div id="grain-options" class="filter-options">
                            <?php
                            $tiposGrano = $conn->query("SELECT Gra_idgrano, Gra_nombre FROM grano");
                            while ($row = $tiposGrano->fetch_assoc()) {
                                $checked = isset($_GET['grainTypes']) && in_array($row['Gra_idgrano'], $_GET['grainTypes']) ? 'checked' : '';
                                echo "
                                    <label>
                                        <input type='checkbox' name='grainTypes[]' value='{$row['Gra_idgrano']}' $checked>
                                        <span>{$row['Gra_nombre']}</span>
                                    </label>";
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit"><b>Aplicar filtros</b></button>
                </div>
            </form>
        </div>

        <!-- Contenedor de Recetas -->
        <div class="recipes-container">
            <div class="recipes">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <a href="recetas.php?id=<?= $row['Rec_idrec'] ?>" class="recipe-link">
                            <div class="recipe-card">
                                <?php
                                $imageData = base64_encode($row['Rec_foto']);
                                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                ?>
                                <img src="<?= $imageSrc ?>" alt="<?= $row['Rec_nombre'] ?>">
                                <div class="recipe-content">
                                    <h4 style="color: #a17157;"><?= $row['Rec_nombre'] ?></h4>
                                    <div class="ratings-container">
                                        <p class="rating">&#11088; <b><?= $row['Rec_calificacion'] ?></b></p>
                                        <div class="tag-circle"><?= $row['Rec_clasificacion'] ?></div>
                                    </div>
                                </div>
                                <p class="uploader">Subido por: <b><?= $row['Rec_nickname'] ?></b></p>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay recetas disponibles.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </div>
    </div>
</main>


<script>
    function toggleFilter(id) {
        const options = document.getElementById(id);
        options.classList.toggle('active');
    }
</script>

<!-- Pie de página -->
<footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
</footer>
</body>
</html>