<?php 
include 'recetas_inicio.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Coffee-P</title>
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
      <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></a></span>
        <span class="user">
        <?php if (isset($_SESSION['user'])): ?>
          <a href="perfil_admin.php">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;"></a>
          </a>
        <?php else: ?>
          <a href="registro.html">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;"></a>
          </a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

  <!-- Contenido principal -->
  <main>
    <div class="container">
        <!-- Contenedor de Filtros -->
        <div class="filters-container">
            <form method="GET" action="">
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

                    <!-- Filtro por Nombre de receta -->
                    <div class="filter-group">
                        <label>
                            <input type="checkbox" onclick="toggleFilter('method-options')" />
                            <span>Nombre de Receta</span>
                        </label>
                        <div id="method-options" class="filter-options">
                            <?php
                            $metodos = $conn->query("SELECT Rec_nombre FROM receta GROUP BY Rec_nombre");
                            while ($row = $metodos->fetch_assoc()) {
                                $checked = isset($_GET['methods']) && in_array($row['Rec_nombre'], $_GET['methods']) ? 'checked' : '';
                                echo "
                                    <label>
                                        <input type='checkbox' name='methods[]' value='{$row['Rec_nombre']}' $checked>
                                        <span>{$row['Rec_nombre']}</span>
                                    </label>";
                            }
                            ?>
                        </div>
                    </div>

                    <button type="submit">Aplicar filtros</button>
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
                                <h4 style="color: #a17157;"><?= $row['Rec_nombre'] ?></h4>
                                <p class="rating">&#11088; <b><?= $row['Rec_calificacion'] ?></b></p>
                                <span class="tag"><?= $row['Rec_clasificacion'] ?></span>
                                <p style="margin-top:10px; font-size:13px;">Subido por: <b><?= $row['Rec_nickname'] ?></b></p>
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
