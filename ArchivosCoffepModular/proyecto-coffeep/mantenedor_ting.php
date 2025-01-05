<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor - Coffee-P</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mantenedor.css">
    <link rel="icon" href="images/favicon.png">
</head>
<body>
<!-- Encabezado -->
  <header>
    <nav>
      <ul>
        <li><a href="mantenedor_ting.php">Mantenedor</a></li>
        <li><a href="generar_listusu.php">Listado</a></li>
      </ul>
      <div class="icons">
        <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></span>
        <span class="user">
        <?php if (isset($_SESSION['user'])): ?>
          <a href="perfil_admin.php">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
          </a>
        <?php else: ?>
          <a href="registro.php">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
          </a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

<main>
    <div class="container">
        <div class="sidebar">
            <h3>Gestión</h3>
            <a href="generar_listusu.php"><button class="sidebar-button">Listado Usuarios</button></a>
            <button class="sidebar-button">Tipo de ingrediente</button>
        </div>

        <div class="content">
            <div class="table-container">
                <?php
                include 'conexion.php';
                // Consulta SQL
                $sql_check = "SELECT tipo_ingrediente.Tip_idtipo, tipo_ingrediente.Tip_nombre FROM tipo_ingrediente LIMIT 10";
                $result = $conn->query($sql_check);
                
                // Comienza a generar la tabla
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Nombre</th>';
                echo '<th>Editar</th>';
                echo '<th>Gestión</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                // Generar filas
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row["Tip_idtipo"]) . '</td>';
                        echo '<td id="name-' . $row["Tip_idtipo"] . '">' . htmlspecialchars($row["Tip_nombre"]) . '</td>';
                        echo '<td>
                                <button class="editar" onclick="mostrarFormulario(\'' . $row["Tip_idtipo"] . '\')">Editar</button>
                              </td>';
                        echo '<td><a href="eliminar_ting.php?id=' . urlencode($row["Tip_idtipo"]) . '" style="color: red; text-decoration: none;" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')">Eliminar</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No se encontraron resultados.</td></tr>';
                }
                echo '</tbody>';
                echo '</table>';
                $conn->close();
                ?>
                
                <!-- Formulario oculto para editar -->
                <div id="edit-form" style="display: none; margin-top: 20px;">
                    <h3>Editar Nombre</h3>
                    <form onsubmit="procesarEdicion(event)">
                        <input type="hidden" id="edit-id" name="id">
                        <label for="edit-nombre">Nuevo Nombre:</label>
                        <input type="text" id="edit-nombre" name="nombre" required>
                        <button type="submit">Guardar</button>
                        <button type="button" onclick="ocultarFormulario()">Cancelar</button>
                    </form>
                    <p id="edit-mensaje" style="margin-top: 10px; font-weight: bold;"></p>
                </div>
                
                <!-- Formulario para agregar -->
                <div id="formulario">
                    <form name="nombre" method="POST" action="agregar_ting.php" onsubmit="return procesarFormulario(event);">
                        <label for="nombre">Nombre del ingrediente:</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ejemplo: Azúcar" required>
                        <button type="submit">Guardar</button>
                    </form>
                    <p id="mensaje" style="margin-top: 10px; font-weight: bold;"></p>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Pie de página -->
<footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
</footer>

<!-- Enlace al archivo externo de JavaScript -->
<script src="scripts.js"></script>
</body>
</html>
