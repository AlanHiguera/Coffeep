<?php 
include 'recetas_inicio.php'; 
include 'conexion.php'; // Conexión a la base de datos

// Obtener datos para los filtros
$ingredientes_query = "SELECT Ing_iding, Ing_nombre FROM ingrediente";
$ingredientes_result = $conn->query($ingredientes_query);

$granos_query = "SELECT Gra_idgrano, Gra_nombre FROM grano";
$granos_result = $conn->query($granos_query);

$nicknames_query = "SELECT DISTINCT Rec_nickname FROM receta";
$nicknames_result = $conn->query($nicknames_query);

$metodos_query = "SELECT DISTINCT Rec_metodo FROM receta";
$metodos_result = $conn->query($metodos_query);

// Construir consulta dinámica
$ingrediente = isset($_GET['ingrediente']) ? $_GET['ingrediente'] : null;
$grano = isset($_GET['grano']) ? $_GET['grano'] : null;
$nickname = isset($_GET['nickname']) ? $_GET['nickname'] : null;
$metodo = isset($_GET['metodo']) ? $_GET['metodo'] : null;

$query = "
  SELECT DISTINCT R.*
  FROM receta R
  LEFT JOIN cantidad_ingrediente CI ON R.Rec_idrec = CI.Can_idrec
  LEFT JOIN ingrediente I ON CI.Can_iding = I.Ing_iding
  LEFT JOIN grano G ON R.Rec_idgrano = G.Gra_idgrano
  WHERE 1 = 1
";

if ($ingrediente) {
  $query .= " AND I.Ing_iding IN (" . implode(',', $ingrediente) . ")";
}
if ($grano) {
  $query .= " AND G.Gra_idgrano = $grano";
}
if ($nickname) {
  $query .= " AND R.Rec_nickname = '$nickname'";
}
if ($metodo) {
  $query .= " AND R.Rec_metodo = '$metodo'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Coffee-P</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estilo.css">
  <link rel="stylesheet" href="recetas.css">
  <script>
    function toggleFilter(filterId) {
      const filter = document.getElementById(filterId);
      filter.style.display = filter.style.display === 'block' ? 'none' : 'block';
    }
  </script>
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

  <main>
      <div class="container">
      <div>
      <form method="GET" action="">
      <!-- Contenedor general de los filtros con ajuste a la izquierda -->
      <div style="position: relative; margin-left: -15%; width: 300px;">

        <div style="margin-bottom: 20px;">
          <h3>Filtros por categoría</h3>

          <!-- Filtro por ingredientes -->
          <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <label style="font-weight: bold; color: #6b4f33; cursor: pointer;">
              <input type="checkbox" onclick="toggleFilter('ingredientesFilter')" style="margin-right: 10px;">
              Ingrediente
            </label>
            <div id="ingredientesFilter" style="display: none; margin-top: 10px;">
              <?php while ($row = $ingredientes_result->fetch_assoc()): ?>
                <label style="display: block; margin-bottom: 5px; color: #333;">
                  <input type="checkbox" name="ingrediente[]" value="<?= $row['Ing_iding'] ?>" style="margin-right: 8px;">
                  <?= $row['Ing_nombre'] ?>
                </label>
              <?php endwhile; ?>
            </div>
          </div>

          <!-- Filtro por tipo de grano -->
          <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <label style="font-weight: bold; color: #6b4f33; cursor: pointer;">
              <input type="checkbox" onclick="toggleFilter('granoFilter')" style="margin-right: 10px;">
              Tipo de Grano
            </label>
            <div id="granoFilter" style="display: none; margin-top: 10px;">
              <select name="grano" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Seleccione un grano</option>
                <?php while ($row = $granos_result->fetch_assoc()): ?>
                  <option value="<?= $row['Gra_idgrano'] ?>"><?= $row['Gra_nombre'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Filtro por nickname -->
          <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <label style="font-weight: bold; color: #6b4f33; cursor: pointer;">
              <input type="checkbox" onclick="toggleFilter('nicknameFilter')" style="margin-right: 10px;">
              Nickname
            </label>
            <div id="nicknameFilter" style="display: none; margin-top: 10px;">
              <select name="nickname" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Seleccione un nickname</option>
                <?php while ($row = $nicknames_result->fetch_assoc()): ?>
                  <option value="<?= $row['Rec_nickname'] ?>"><?= $row['Rec_nickname'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>

          <!-- Filtro por método -->
          <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <label style="font-weight: bold; color: #6b4f33; cursor: pointer;">
              <input type="checkbox" onclick="toggleFilter('metodoFilter')" style="margin-right: 10px;">
              Método
            </label>
            <div id="metodoFilter" style="display: none; margin-top: 10px;">
              <select name="metodo" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Seleccione un método</option>
                <?php while ($row = $metodos_result->fetch_assoc()): ?>
                  <option value="<?= $row['Rec_metodo'] ?>"><?= $row['Rec_metodo'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Botón de aplicar filtros -->
        <button type="submit" style="display: block; margin-top: 20px; padding: 10px 20px; background-color: #b3876f; color: white; border: none; border-radius: 5px; cursor: pointer;">
          Aplicar filtros
        </button>
      </div>
    </form>
    </div>
      <!-- Mostrar recetas filtradas -->
      
      <section class="recipes">
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
        </section>
  </main>

  <footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
  </footer>
</body>
</html>
