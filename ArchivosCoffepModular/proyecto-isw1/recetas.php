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

// Variable para mostrar el mensaje
$mostrarMensaje = false;

// Manejar el envío de la calificación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calificacion'])) {
    $calificacion = floatval($_POST['calificacion']);
    $usuario = $_SESSION['user']; // Suponiendo que el usuario está autenticado y su nickname está en la sesión
    $idReceta = $id;

    // Verificar si el usuario ya calificó esta receta
    $sqlVerificar = "SELECT * FROM evaluacion WHERE Eva_nickname = '$usuario' AND Eva_idrec = $idReceta";
    $resultadoVerificar = $conn->query($sqlVerificar);

    if ($resultadoVerificar->num_rows > 0) {
        // Actualizar calificación existente
        $sqlActualizar = "UPDATE evaluacion SET Eva_calificacion = $calificacion WHERE Eva_nickname = '$usuario' AND Eva_idrec = $idReceta";
        $conn->query($sqlActualizar);
    } else {
        // Insertar nueva calificación
        $sqlInsertar = "INSERT INTO evaluacion (Eva_nickname, Eva_idrec, Eva_calificacion, Eva_fecha) VALUES ('$usuario', $idReceta, $calificacion, NOW())";
        $conn->query($sqlInsertar);
    }

    // Actualizar calificación promedio de la receta
    $sqlPromedio = "SELECT AVG(Eva_calificacion) AS promedio FROM evaluacion WHERE Eva_idrec = $idReceta";
    $resultadoPromedio = $conn->query($sqlPromedio);
    if ($resultadoPromedio && $rowPromedio = $resultadoPromedio->fetch_assoc()) {
        $calificacionPromedio = $rowPromedio['promedio'];
        $sqlActualizarReceta = "UPDATE receta SET Rec_calificacion = $calificacionPromedio WHERE Rec_idrec = $idReceta";
        $conn->query($sqlActualizarReceta);
    }

    // Activar el mensaje
    $mostrarMensaje = true;
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
  <link rel="stylesheet" href="calificar.css">  <!-- Archivo CSS específico para estrellas -->
  <link rel="stylesheet" href="style.css"> <!-- Archivo CSS general -->
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
        <?php if ($mostrarMensaje): ?>
            <div id="mensaje-calificacion">
                ¡Gracias por tu calificación! ☕✨
            </div>
        <?php endif; ?>
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
            <div>
            <!-- Formulario de calificación -->
            <form method="POST" class="rating-form">
                <label for="calificacion">Califica esta receta:</label>
                <div class="stars">
                    <input type="radio" id="star5" name="calificacion" value="5" />
                    <label for="star5" class="starelement"></label>

                    <input type="radio" id="star4" name="calificacion" value="4" />
                    <label for="star4" class="starelement"></label>

                    <input type="radio" id="star3" name="calificacion" value="3" />
                    <label for="star3" class="starelement"></label>

                    <input type="radio" id="star2" name="calificacion" value="2" />
                    <label for="star2" class="starelement"></label>

                    <input type="radio" id="star1" name="calificacion" value="1" />
                    <label for="star1" class="starelement"></label>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>Coffee-P &copy; Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const mensaje = document.getElementById('mensaje-calificacion');
            if (mensaje) {
                setTimeout(() => {
                    mensaje.style.transition = "opacity 0.5s ease";
                    mensaje.style.opacity = "0"; // Desvanecer
                    setTimeout(() => mensaje.remove(), 500); // Eliminar después de 0.5 segundos
                }, 2000); // Esperar 3 segundos
            }
        });
    </script>
</body>
</html>
