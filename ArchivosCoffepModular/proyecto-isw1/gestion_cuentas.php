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
  <title>Gestión de Usuarios - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="generar_usu.css">
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
      </div>
    </nav>
  </header>

  <div class="container">
    <div class="table-container">
      <h2>Lista de Usuarios</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>nombre</th>
            <th>Apellido</th>
            <th>Rol</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Conexión a la base de datos
            include "conexion.php";

            // Consulta para obtener los usuarios

            include 'listado_usuarios.php'; // Archivo con la función ListadoTipoIngredientes
            $usuarios = obtenerUsuarios($conn);

            if (!empty($usuarios)) {
                foreach ($usuarios as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Usu_nickname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Usu_correo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Usu_nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Usu_apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Usu_rol']) . "</td>";
                    echo "<td><a class='edit' href='#" . htmlspecialchars($row['Usu_nickname']) . "'>Editar</a></td>";
                    echo "<td><a class='delete' href='#" . htmlspecialchars($row['Usu_nickname']) . "'>Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay usuarios registrados</td></tr>";
            }
            
            echo '</tbody>';
            echo '</table>';
            
            // Cerrar la conexión
            $conn->close();
            ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer>
    Coffee-P &copy; Todos los derechos reservados
  </footer>
</body>
</html>