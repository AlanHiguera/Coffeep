<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include 'conexion.php';

// Obtener el ID de la receta a editar
if (!isset($_GET['rec_id'])) {
    header("Location: perfil_admin.php"); // Si no hay ID, redirige al perfil
    exit();
}

$rec_id = $_GET['rec_id'];

// Obtener datos de la receta existente
$receta = mysqli_query($conn, "SELECT * FROM receta WHERE rec_id = '$rec_id'");
$datos_receta = mysqli_fetch_assoc($receta);

// Obtener lista de granos e ingredientes
$granos = mysqli_query($conn, "SELECT Gra_idgrano, Gra_nombre FROM grano");
$ingredientes = mysqli_query($conn, "SELECT Ing_iding, Ing_nombre FROM ingrediente");

// Obtener ingredientes de la receta
$receta_ingredientes = mysqli_query($conn, "SELECT Ing_iding FROM receta_ingrediente WHERE rec_id = '$rec_id'");
$ingredientes_seleccionados = [];
while ($row = mysqli_fetch_assoc($receta_ingredientes)) {
    $ingredientes_seleccionados[] = $row['Ing_iding'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receta - Coffee-P</title>
    <link rel="stylesheet" href="crear_receta.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <div class="form-content">
                <h1>Editar Receta</h1>
                <form action="actualizar_receta.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="rec_id" value="<?php echo $rec_id; ?>">
                    <div class="form-group">
                        <label for="rec_nombre">Nombre de la receta:</label>
                        <input type="text" id="rec_nombre" name="rec_nombre" required value="<?php echo $datos_receta['rec_nombre']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="rec_preparacion">Preparación:</label>
                        <textarea id="rec_preparacion" name="rec_preparacion" required rows="5"><?php echo $datos_receta['rec_preparacion']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rec_grano">Seleccionar Grano:</label>
                        <select id="rec_grano" name="rec_grano" required>
                            <option value="">-- Selecciona un grano --</option>
                            <?php while ($grano = mysqli_fetch_assoc($granos)) { ?>
                                <option value="<?php echo $grano['Gra_idgrano']; ?>" <?php echo ($datos_receta['Gra_idgrano'] == $grano['Gra_idgrano']) ? 'selected' : ''; ?>>
                                    <?php echo $grano['Gra_nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ingredientes:</label>
                        <div id="ingredientes-container">
                            <?php while ($ingrediente = mysqli_fetch_assoc($ingredientes)) { ?>
                                <div class="ingrediente">
                                    <input type="checkbox" name="ingredientes[]" value="<?php echo $ingrediente['Ing_iding']; ?>" <?php echo (in_array($ingrediente['Ing_iding'], $ingredientes_seleccionados)) ? 'checked' : ''; ?>>
                                    <?php echo $ingrediente['Ing_nombre']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rec_metodo">Método:</label>
                        <input type="text" id="rec_metodo" name="rec_metodo" required value="<?php echo $datos_receta['rec_metodo']; ?>">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="age_restriction" name="age_restriction" <?php echo ($datos_receta['age_restriction']) ? 'checked' : ''; ?>>
                        <label for="age_restriction">Restricción de edad</label>
                    </div>

                    <button type="submit" class="btn-primary">Actualizar Receta</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>Coffee-P &copy; Todos los derechos reservados.</p>
    </footer>
</body>
</html>
