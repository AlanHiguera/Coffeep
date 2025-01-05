<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Archivo para conectar a la base de datos

// Obtener datos dinámicos de las tablas grano e ingrediente
$granos = mysqli_query($conn, "SELECT Gra_idgrano, Gra_nombre FROM grano");
$ingredientes = mysqli_query($conn, "SELECT Ing_iding, Ing_nombre FROM ingrediente");
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
    <link rel="stylesheet" href="crear_rec.css">
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
            <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></span>
            <span class="user">
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
                <?php endif; 
            else: ?>
                <a href="registro.html">
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
                            <?php while ($grano = mysqli_fetch_assoc($granos)) { ?>
                                <option value="<?php echo $grano['Gra_idgrano']; ?>">
                                    <?php echo $grano['Gra_nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Ingredientes dinámicos -->
                    <div class="form-group">
                        <label>Ingredientes:</label>
                        <div id="ingredientes-container">
                            <div class="ingrediente">
                                <select name="ingredientes[]" required>
                                    <option value="">-- Selecciona un ingrediente --</option>
                                    <?php while ($ingrediente = mysqli_fetch_assoc($ingredientes)) { ?>
                                        <option value="<?php echo $ingrediente['Ing_iding']; ?>">
                                            <?php echo $ingrediente['Ing_nombre']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
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
                        <input type="checkbox" id="age_restriction" name="age_restriction">
                        <label for="age_restriction">Restricción de edad</label>
                    </div>

                    <button type="submit" class="btn-primary">Crear Receta</button>
                </form>
            </div>

            <div class="form-content">
                <h2>Añadir Foto</h2>
                <form action="publicar_receta.php" method="POST" enctype="multipart/form-data">
                    <!-- Subir imagen -->
                    <div class="form-group">
                        <label for="rec_foto">Añadir Foto:</label>
                        <input type="file" id="rec_foto" name="rec_foto" accept="image/*" required>
                    </div>
                   <!-- <button type="submit" class="btn-primary">Subir Foto</button> -->
                </form>
            </div>
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
                    <?php
                    $ingredientes = mysqli_query($conn, "SELECT Ing_iding, Ing_nombre FROM ingrediente");
                    while ($ingrediente = mysqli_fetch_assoc($ingredientes)) {
                        echo '<option value="' . $ingrediente['Ing_iding'] . '">' . $ingrediente['Ing_nombre'] . '</option>';
                    }
                    ?>
                </select>
                <button type="button" class="remove-ingrediente">Eliminar</button>
            `;
            container.appendChild(newIngrediente);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-ingrediente')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</body>
</html>