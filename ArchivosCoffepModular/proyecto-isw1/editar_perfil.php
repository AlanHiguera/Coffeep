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

  <div class="container">
    <div class="table-container">
      <h2>Lista de Usuarios</h2>
        <tbody>
        <?php
        // Conexión a la base de datos
        include "conexion.php";

        // Obtener los usuarios desde la función
        include 'listado_usuario_unico.php';
        $usuario = obtenerUsuarioUnico($conn);
        
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nickname</th>";
        echo "<th>Correo</th>";
        echo "<th>Nombre</th>";
        echo "<th>Apellido</th>";
        echo "<th>Rol</th>";
        echo "<th>Estado</th>";
        echo "<th>Cambiar estado</th>";
        echo "<th>Editar datos</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        if (!empty($usuario)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($usuario['Usu_nickname']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['Usu_correo']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['Usu_nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['Usu_apellido']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['Usu_rol']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['Usu_estado']) . "</td>";
        
            // Enlace para cambiar el estado
            echo "<td><a class='change-status' href='cambiar_estado.php?nickname=" . htmlspecialchars($usuario['Usu_nickname']) . "'>Cambiar estado</a></td>";
        
            // Formulario para editar nombre y apellido dentro de la tabla
            echo "<td>";
            echo "<form action='editar_usuario.php' method='POST'>";
            echo "<input type='hidden' name='nickname' value='" . htmlspecialchars($usuario['Usu_nickname']) . "'>";
            echo "<input type='text' name='nombre' value='" . htmlspecialchars($usuario['Usu_nombre']) . "' required>";
            echo "<input type='text' name='apellido' value='" . htmlspecialchars($usuario['Usu_apellido']) . "' required>";
            echo "<input type='email' name='correo' value='" . htmlspecialchars($usuario['Usu_correo']) . "' required>";
            
            echo "<button type='submit'>Actualizar</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        } else {
            echo "<tr><td colspan='8'>No se encontraron datos para este usuario</td></tr>";
        }
        
        echo '</tbody>';
        echo '</table>';
        
        // Cerrar la conexión a la base de datos
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