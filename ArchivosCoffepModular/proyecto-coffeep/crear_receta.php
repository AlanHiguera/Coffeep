<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include 'conexion.php'; // Archivo para conectar a la base de datos

$mostrarMensaje = false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Receta - Coffee-P</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="crear_receta.css">
    <link rel="icon" href="images/favicon.png">
</head>
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
        <div class="form-container">
            <div class="form-content">
                <h1>Crear Receta</h1>
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <p class="success-message">Receta guardada exitosamente.</p>
                <?php endif; ?>

                <form action="publicar_receta.php" method="POST" enctype="multipart/form-data">
                    <?php
                        if (isset($_SESSION['mensaje'])) {
                            echo '<div id="mensaje-style">' . $_SESSION['mensaje'] . '</div>';
                            unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
                        }
                    ?>
                    
                    <!-- Nombre de la receta -->
                    <div class="form-group">
                        <label for="rec_nombre">Nombre de la receta:</label>
                        <input type="text" id="rec_nombre" name="rec_nombre" required placeholder="Ejemplo: Café especial">
                    </div>

                    <!-- Preparación -->
                    <div class="form-group">
                        <label for="rec_preparacion">Preparación:</label>
                        <textarea id="rec_preparacion" name="rec_preparacion" required placeholder="Describe los pasos..." rows="5"></textarea>
                    </div>

                    <!-- Seleccionar grano -->
                    <div class="form-group">
                        <label for="rec_grano">Seleccionar Grano:</label>
                        <select id="rec_grano" name="rec_grano" required>
                            <option value="">-- Selecciona un grano --</option>
                            <?php include 'obtener_granos.php'; ?>
                        </select>
                    </div>

                    <!-- Ingredientes dinámicos -->
                    <div class="form-group">
                        <label>Ingredientes:</label>
                        <div id="ingredientes-container">
                            <div class="ingrediente">
                                <select name="ingredientes[]" required>
                                    <option value="">-- Selecciona un ingrediente --</option>
                                    <?php include 'obtener_ingredientes.php'; ?>
                                </select>
                                <input type="text" name="cantidades[]" placeholder="Cantidad (ej. 200g)" required>
                                <button type="button" class="remove-ingrediente">Eliminar</button>
                            </div>
                        </div>
                        <button type="button" id="add-ingrediente" class="btn-secondary">Agregar ingrediente</button>
                    </div>

                    <!-- Método -->
                    <div class="form-group">
                        <label for="rec_metodo">Método:</label>
                        <input type="text" id="rec_metodo" name="rec_metodo" required placeholder="Ejemplo: Espresso">
                    </div>
            
                    <!-- Restricción de edad -->
                    <div class="form-group age-restriction">
                        <input type="checkbox" id="rec_clasificacion" name="rec_clasificacion" value="ATP">
                        <label for="rec_clasificacion">Restricción de edad</label>
                    </div>

                    <!-- Botón de enviar -->
                    <button type="submit" class="btn-primary">Publicar Receta</button>
                    
                    <?php
                        $mostrarMensaje = true;
                    ?>

                    <p class="nota-foto">
                    *Al publicar esta receta declaras que la información presente no contiene productos dañinos para la salud ni presenta uso de lenguaje inadecuado. Ante cualquier incumplimiento de normas, asumes total responsabilidad de lo presente en la publicación.
                    </p> 
        </div>
                    <!-- Contenedor de la foto aparte -->
                    <div class ="form-content" id="foto-cuadro">
                        <h2>Añadir foto</h2>
                        <div id="foto-container">
                            <img id="foto-preview" src="#" alt="Vista previa de la foto">
                        </div>

                        <input type="file" id="rec_foto" name="rec_foto" accept="image/*" style="padding: none;" required>
                        <p class="nota-foto">
                            *Ante cualquier imagen que incumpla las normas, corres el riesgo de perder tu cuenta.
                        </p> 
                    </div>

                    
                </form>
            
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>Coffee-P &copy; Todos los derechos reservados.</p>
    </footer>

    <script>
        // Script para agregar y eliminar ingredientes dinámicamente
        document.getElementById('add-ingrediente').addEventListener('click', function() {
                    var container = document.getElementById('ingredientes-container');
                    var newIngrediente = document.createElement('div');
                    newIngrediente.classList.add('ingrediente');
                    newIngrediente.innerHTML = `
                        <select name="ingredientes[]" required>
                            <option value="">-- Selecciona un ingrediente --</option>
                            <?php include 'obtener_ingredientes.php'; ?>
                        </select>
                        <input type="text" name="cantidades[]" placeholder="Cantidad (ej. 200g)" required>
                        <button type="button" class="remove-ingrediente">Eliminar</button>
                    `;
                    container.appendChild(newIngrediente);
                });

                document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-ingrediente')) {
                e.target.parentElement.remove();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const mensaje = document.getElementById('mensaje-style');
            if (mensaje) {
                setTimeout(() => {
                    mensaje.style.transition = "opacity 0.5s ease";
                    mensaje.style.opacity = "0"; // Desvanecer
                    setTimeout(() => mensaje.remove(), 500); // Eliminar después de 0.5 segundos
                }, 2000); // Esperar 3 segundos
            }
        });

        document.getElementById('rec_foto').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('foto-preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>
</body>
</html>