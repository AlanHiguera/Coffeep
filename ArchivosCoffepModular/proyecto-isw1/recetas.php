<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php';

// Verificar si el ID está presente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta a la base de datos
    $sql = "SELECT * FROM receta WHERE Rec_idrec = $id";
    $result = $conn->query($sql);

    // Verificar si existe la receta
    if ($result && $result->num_rows > 0) {
        $receta = $result->fetch_assoc();
    } else {
        echo "Receta no encontrada.";
        exit;
    }
} else {
    echo "ID de receta no especificado.";
    exit;
}
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
  <link rel="stylesheet" href="recetas.css">
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
        <div class="recipe-detail">
            <img src="data:image/jpeg;base64,<?= base64_encode($receta['Rec_foto']) ?>" alt="<?= $receta['Rec_nombre'] ?>">
            <h1><?= $receta['Rec_nombre'] ?></h1>
            <p>Por: <?= $receta['Rec_nickname'] ?></p>
            <p>Fecha de publicación: <?= $receta['Rec_fecha_pub'] ?></p>
            <p><strong>Calificación:</strong> ⭐ <?= $receta['Rec_calificacion'] ?></p>
            <p><strong>Categoría:</strong> <?= $receta['Rec_clasificacion'] ?></p>

            <h3>Ingredientes:</h3>
            <p>no hay conexion con ingrediente todavia</p>

            <h3>Preparación:</h3>
            <p><?= nl2br($receta['Rec_preparacion']) ?></p>

            <strong>Método:</strong>
            <p><?= $receta['Rec_metodo'] ?></p>
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>Coffee-P &copy; Todos los derechos reservados.</p>
    </footer>
</body>
</html>
