<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include 'conexion.php';

// Verificar si el ID está presente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta la receta
    $sql = "SELECT * FROM receta WHERE Rec_idrec = $id";
    $result = $conn->query($sql);

    // Verificar si existe la receta
    if ($result && $result->num_rows > 0) {
        $receta = $result->fetch_assoc();
    } else {
        echo "Receta no encontrada.";
        exit;
    }

    // Consulta para obtener los ingredientes de la receta
    $sqlIngredientes = "SELECT Ing_nombre, Can_cantidad FROM cantidad_ingrediente, ingrediente  ingrediente WHERE Ing_iding = Can_iding AND Can_idrec = $id";
    $resultIngredientes = $conn->query($sqlIngredientes);

    $ingredientes = [];
    if ($resultIngredientes && $resultIngredientes->num_rows > 0) {
        while ($ingrediente = $resultIngredientes->fetch_assoc()) {
            // Redondear la cantidad a 1 decimal
            $ingrediente['Can_cantidad'] = round($ingrediente['Can_cantidad'], 1);
            $ingredientes[] = $ingrediente;
        }
    }

    // Procesar nuevo comentario o respuesta
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {
        $comentario = $conn->real_escape_string($_POST['comentario']);
        $usuario = $_SESSION['user'];
        $idResp = $_POST['idresp'] === "NULL" ? "NULL" : intval($_POST['idresp']); // NULL si es comentario principal
        
        // Determinar si es un comentario o una respuesta
        $tipocom = $idResp === "NULL" ? 1 : 0;
    
        $sql_insert = "INSERT INTO comentario (Com_contenido, Com_cant_likes, Com_fecha, Com_idrec, Com_nickname, Com_idresp, Com_tipocom) 
                    VALUES ('$comentario', 0, CURRENT_DATE(), '$id', '$usuario', $idResp, $tipocom)";
        $conn->query($sql_insert);
    }

    // Manejar la eliminación de comentarios
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_comentario'])) {
        $idComentario = intval($_POST['idcomentario']);
        $usuario = $_SESSION['user'];
    
        // Verificar si el usuario es el autor del comentario
        $sqlVerificar = "SELECT * FROM comentario WHERE Com_idcom = $idComentario AND Com_nickname = '$usuario'";
        $resultVerificar = $conn->query($sqlVerificar);
    
        if ($resultVerificar && $resultVerificar->num_rows > 0) {
            // Eliminar primero las respuestas asociadas
            $sqlEliminarRespuestas = "DELETE FROM comentario WHERE Com_idresp = $idComentario";
            $conn->query($sqlEliminarRespuestas);
    
            // Luego eliminar el comentario principal
            $sqlEliminarPrincipal = "DELETE FROM comentario WHERE Com_idcom = $idComentario";
            $conn->query($sqlEliminarPrincipal);
    
            // Redirigir para evitar reenvíos de formulario
            header("Location: " . $_SERVER['PHP_SELF'] . "?id=$id");
            exit();
        }
    }

    // Obtener los comentarios principales (sin respuesta a otro comentario)
    $sqlComentarios = "SELECT * FROM comentario WHERE Com_idrec = $id AND Com_idresp IS NULL ORDER BY Com_fecha DESC";
    $resultComentarios = $conn->query($sqlComentarios);

    $comentarios = [];
    if ($resultComentarios && $resultComentarios->num_rows > 0) {
        while ($comentario = $resultComentarios->fetch_assoc()) {
            // Buscar las respuestas asociadas a este comentario
            $idCom = $comentario['Com_idcom'];
            $sqlRespuestas = "SELECT * FROM comentario WHERE Com_idresp = $idCom ORDER BY Com_fecha ASC";
            $resultRespuestas = $conn->query($sqlRespuestas);
            
            $respuestas = [];
            if ($resultRespuestas && $resultRespuestas->num_rows > 0) {
                while ($respuesta = $resultRespuestas->fetch_assoc()) {
                    $respuestas[] = $respuesta;
                }
            }
            
            // Añadir respuestas al comentario principal
            $comentario['respuestas'] = $respuestas;
            $comentarios[] = $comentario;
        }
    }

    // Manejar el guardado o desguardado de la receta
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_receta'])) {
        $idReceta = intval($_POST['guardar_receta']);
        $usuario = $_SESSION['user']; // Usuario autenticado

        // Verificar si la receta ya está guardada
        $sqlVerificarGuardado = "SELECT * FROM guardado WHERE Gua_nickname = '$usuario' AND Gua_idrec = $idReceta";
        $resultadoVerificar = $conn->query($sqlVerificarGuardado);

        if ($resultadoVerificar->num_rows > 0) {
            // Si está guardada, eliminarla (desguardar)
            $sqlDesguardar = "DELETE FROM guardado WHERE Gua_nickname = '$usuario' AND Gua_idrec = $idReceta";
            if ($conn->query($sqlDesguardar)) {
                $mensajeGuardar = "Receta eliminada de tus guardados.";
            } else {
                $mensajeGuardar = "Hubo un error al intentar desguardar la receta.";
            }
        } else {
            // Si no está guardada, agregarla
            $sqlGuardar = "INSERT INTO guardado (Gua_nickname, Gua_idrec) VALUES ('$usuario', $idReceta)";
            if ($conn->query($sqlGuardar)) {
                $mensajeGuardar = "¡Receta guardada correctamente!";
            } else {
                $mensajeGuardar = "Hubo un error al guardar la receta.";
            }
        }
    }

    // Verificar si la receta ya está guardada
    $sqlVerificarGuardadoInicial = "SELECT * FROM guardado WHERE Gua_nickname = '{$_SESSION['user']}' AND Gua_idrec = $id";
    $estaGuardada = ($conn->query($sqlVerificarGuardadoInicial)->num_rows > 0);

    // Manejar la eliminación de recetas
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_receta'])) {
        $idReceta = intval($_POST['eliminar_receta']);
        $usuario = $_SESSION['user'];
        $rol = $_SESSION['rol'];
    
        // Verificar si el usuario tiene permiso para eliminar la receta
        $sqlVerificar = "SELECT * FROM receta WHERE Rec_idrec = $idReceta AND (Rec_nickname = '$usuario' OR '$rol' = 'Administrador')";
        $resultadoVerificar = $conn->query($sqlVerificar);
    
        if ($resultadoVerificar && $resultadoVerificar->num_rows > 0) {
            // Eliminar la receta
            $sqlEliminarReceta = "DELETE FROM receta WHERE Rec_idrec = $idReceta";
            if ($conn->query($sqlEliminarReceta)) {
                // Redirigir tras la eliminación exitosa
                header("Location: inicio.php"); // Cambia `inicio.php` por tu página principal
                exit();
            } else {
                echo "Error al eliminar la receta.";
            }
        } else {
            echo "No tienes permiso para eliminar esta receta.";
        }
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
  <title>Receta N°<?= $receta['Rec_idrec'] ?> - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="recetas.css">
  <link rel="stylesheet" href="calificar.css">
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

<main>
    <?php if ($mostrarMensaje): ?>
            <div id="mensaje-calificacion">
                ¡Gracias por tu calificación! ☕✨
            </div>
        <?php endif; ?>
    <div class="recipe-detail">
        <img src="data:image/jpeg;base64,<?= base64_encode($receta['Rec_foto']) ?>" alt="<?= $receta['Rec_nombre'] ?>">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1><?= $receta['Rec_nombre'] ?></h1>
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="guardar_receta" value="<?= $id ?>">
                <button type="submit" class="save-button">
                    <?= $estaGuardada ? "<img src='images/quitar.png' style='width: 40px; height: 40px;'></a>" : "<img src='images/guardar.png' style='width: 40px; height: 40px;'></a>" ?>
                </button>
                <!-- Mostrar mensaje de guardar receta -->
                <?php if (isset($mensajeGuardar)): ?>
                    <div id="mensaje-guardar" class="mensaje">
                        <?= htmlspecialchars($mensajeGuardar) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <p><b>Clasificación:</b> <?= $receta['Rec_clasificacion']?></p>
        <p><b>Autor/a:</b> <?= $receta['Rec_nickname'] ?></p>
        <p><b>Fecha de publicación:</b> <?= $receta['Rec_fecha_pub'] ?></p>
        <p><b>Calificación: &#11088; </b> <?= $receta['Rec_calificacion'] ?></p>
        
        <h3>Ingredientes:</h3>
        <ul>
            <?php if (!empty($ingredientes)): ?>
                <?php foreach ($ingredientes as $ingrediente): ?>
                    <li><?= htmlspecialchars($ingrediente['Can_cantidad']) . 'g de ' . htmlspecialchars($ingrediente['Ing_nombre']) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay ingredientes asociados a esta receta.</p>
            <?php endif; ?>

        <h3>Método:</h3>
        <p><?= $receta['Rec_metodo'] ?></p>

        <h3>Preparación:</h3>
        <p><?= nl2br($receta['Rec_preparacion']) ?></p><br>

        <!-- Información nutricional -->
        <h3>Información Nutricional:</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <tr>
                <th style="padding: 8px;">Grasas (g)</th>
                <th style="padding: 8px;">Proteínas (g)</th>
                <th style="padding: 8px;">Hidratos (g)</th>
                <th style="padding: 8px;">Azúcares (g)</th>
                <th style="padding: 8px;">Sodio (mg)</th>
                <th style="padding: 8px;">Colesterol (mg)</th>
            </tr>
            <tr>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_grasas']) ?></td>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_proteinas']) ?></td>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_hidratos']) ?></td>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_azucares']) ?></td>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_sodio']) ?></td>
                <td style="padding: 8px;"><?= htmlspecialchars($receta['Rec_colesterol']) ?></td>
            </tr>
        </table>

        
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
        
        <!-- Eliminar recetas-->
        <?php if ($_SESSION['rol'] === 'Administrador' || $_SESSION['user'] === $receta['Rec_nickname']): ?>
            <form method="POST" style="margin-top: 20px;">
                <input type="hidden" name="eliminar_receta" value="<?= $receta['Rec_idrec'] ?>">
                <button type="submit" class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta receta? Esta acción no se puede deshacer.');">
                    Eliminar receta
                </button>
            </form>
        <?php endif; ?>

    </div>

 <!-- Sección de comentarios -->
<div class="comments-section">
    <h2>Comentarios</h2>
    <?php if ($resultComentarios && $resultComentarios->num_rows > 0): ?>
        <?php foreach ($comentarios as $comentario): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comentario['Com_nickname']) ?>:</strong> <?= htmlspecialchars($comentario['Com_contenido']) ?></p>
                <small><?= htmlspecialchars($comentario['Com_fecha']) ?></small>
    
                <!-- Verificar si el usuario puede eliminar el comentario -->
                <?php if ($_SESSION['rol'] === 'Administrador' || $comentario['Com_nickname'] === $_SESSION['user']): ?>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="idcomentario" value="<?= $comentario['Com_idcom'] ?>">
                        <button type="submit" name="eliminar_comentario">Eliminar</button>
                    </form>
                <?php endif; ?>
                
                <button class="show-replies-btn" data-id="<?= $comentario['Com_idcom'] ?>">Ver respuestas (<?= count($comentario['respuestas']) ?>)</button>
                
                <!-- Contenedor de respuestas -->
                <div class="replies" id="replies-<?= $comentario['Com_idcom'] ?>" style="display: none;">
                    <?php foreach ($comentario['respuestas'] as $respuesta): ?>
                        <div class="reply">
                            <p><strong><?= htmlspecialchars($respuesta['Com_nickname']) ?>:</strong> <?= htmlspecialchars($respuesta['Com_contenido']) ?></p>
                            <small><?= htmlspecialchars($respuesta['Com_fecha']) ?></small>
                            
                            <!-- Verificar si el usuario puede eliminar la respuesta -->
                            <?php if ($_SESSION['rol'] === 'Administrador' || $respuesta['Com_nickname'] === $_SESSION['user']): ?>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="idcomentario" value="<?= $respuesta['Com_idcom'] ?>">
                                    <button type="submit" name="eliminar_comentario">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <!-- Formulario para responder a este comentario -->
                    <form action="" method="POST" class="reply-form">
                        <textarea name="comentario" rows="2" required placeholder="Escribe tu respuesta aquí..."></textarea>
                        <input type="hidden" name="idresp" value="<?= $comentario['Com_idcom'] ?>"> <!-- ID del comentario padre -->
                        <button type="submit">Responder</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
    <?php endif; ?>

    <!-- Formulario para agregar un comentario principal -->
    <form action="" method="POST" class="comment-form">
        <textarea name="comentario" rows="4" required placeholder="Escribe tu comentario aquí..."></textarea>
        <input type="hidden" name="idresp" value="NULL"> <!-- Comentario principal -->
        <button type="submit">Enviar</button>
    </form>
</div>


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
        
    document.addEventListener('DOMContentLoaded', () => {
        const replyButtons = document.querySelectorAll('.show-replies-btn');
        
        replyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const repliesId = button.getAttribute('data-id');
                const repliesContainer = document.getElementById(`replies-${repliesId}`);
                
                if (repliesContainer.style.display === 'none') {
                    repliesContainer.style.display = 'block';
                    button.textContent = 'Ocultar respuestas';
                } else {
                    repliesContainer.style.display = 'none';
                    button.textContent = `Ver respuestas (${repliesContainer.childElementCount - 1})`;
                }
            });
        });
    });

   document.addEventListener('DOMContentLoaded', () => {
    // Lógica para eliminar comentarios dinámicamente
    document.querySelectorAll('form[action=""]').forEach(form => {
        const deleteButton = form.querySelector('button[name="eliminar_comentario"]');
        if (deleteButton) {
            deleteButton.addEventListener('click', (event) => {
                if (!confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
                    event.preventDefault(); // Cancela el envío si el usuario no confirma
                }
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const mensajeGuardar = document.getElementById('mensaje-guardar');
    if (mensajeGuardar) {
        setTimeout(() => {
            mensajeGuardar.style.transition = "opacity 0.5s ease";
            mensajeGuardar.style.opacity = "0"; // Desvanecer
            setTimeout(() => mensajeGuardar.remove(), 500); // Eliminar después de 0.5 segundos
        }, 3000); // Mostrar el mensaje por 3 segundos
    }
});

</script>


</main>


<footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
</footer>
</body>
</html>
