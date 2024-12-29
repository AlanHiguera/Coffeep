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
  <link rel="stylesheet" href="estilo.css">
  <link rel="icon" href="images/favicon.png">
</head>
<body>
  <!-- Encabezado -->
  <header>
    <nav>
      <ul>
        <li><a href="inicio.php">Inicio</a></li>
        <li><a href="contacto.php">Contacto</a></li>
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
        </span>
      </div>
    </nav>
  </header>

  <!-- Contenido principal -->
  <main>
    <div class="container">
      <form method="GET" action="">
        <div class="filters">
            <h3>Filtros por categoría</h3>
            <div class="filter-group">
                <label>
                    <input type="checkbox" name="ranking" value="1" <?php if (isset($_GET['ranking'])) echo 'checked'; ?>>
                    <span>Ranking</span>
                </label>
                <label>
                    <input type="checkbox" name="ingredient">
                    <span>Ingrediente</span>
                </label>
                <label>
                    <input type="checkbox" name="grain-type">
                    <span>Variedad de grano</span>
                </label>
                <label>
                    <input type="checkbox" name="method">
                    <span>Método</span>
                </label>
            </div>
            <button type="submit">Aplicar filtros</button>
        </div>
      </form>

      <!-- Recetas -->
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
                        <h4><?= $row['Rec_nombre'] ?></h4>
                        <p class="rating">⭐ <?= $row['Rec_calificacion'] ?></p>
                        <span class="tag"><?= $row['Rec_clasificacion'] ?></span>
                        <p><?= $row['Rec_nickname'] ?></p>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay recetas disponibles.</p>
        <?php endif; ?>
        <?php $conn->close(); ?>
      </div>   
  </main>

  <!-- Pie de página -->
  <footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
  </footer>
</body>
</html>