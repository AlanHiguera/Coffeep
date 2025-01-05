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
            <li><a href="guia.php">Infromación</a></li>
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

  <div class="container">
    <div class="table-container">
      <h2>Lista de Usuarios</h2>
        <tbody>
        <?php
        // Conexión a la base de datos
        include "conexion.php";

        // Obtener los usuarios desde la funció
        
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Foto</th>";
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
        
        $nickname = $conn->real_escape_string($_SESSION['user']); // Escapar el valor por seguridad

        // Consulta SQL para obtener los datos del usuario autenticado
        $sql_check = "SELECT Usu_nickname, Usu_correo, Usu_nombre, Usu_apellido, Usu_rol, Usu_estado, Usu_foto
                      FROM usuario 
                      WHERE Usu_nickname = '$nickname'";

        $usuarios = $conn->query($sql_check);
        if ($usuarios->num_rows > 0){
            // Imprimir filas de la tabla
            while ($row = $usuarios->fetch_assoc()) {
                echo "<tr>";
                // Codificar la imagen en base64
                $imageData = base64_encode($row['Usu_foto']);
                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
            
                echo "<td><img src='" . $imageSrc . "' alt='' style='width: 50px; height: 50px;' /></td>";
                echo "<td>" . htmlspecialchars($row['Usu_nickname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Usu_correo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Usu_nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Usu_apellido']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Usu_rol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Usu_estado']) . "</td>";
            
                // Enlace para cambiar el estado
                echo "<td><a class='change-status' href='cambiar_estado.php?nickname=" . htmlspecialchars($row['Usu_nickname']) . "'>Cambiar estado</a></td>";
            
                // Formulario para editar datos
                echo "<td>";
                echo "<form action='editar_usuario.php' method='POST' enctype='multipart/form-data' class='edit-form' style='display: flex; flex-direction: column; gap: 10px; align-items: flex-start;'>"; // Flexbox para mejor alineación
                echo "<input type='hidden' name='nickname' value='" . htmlspecialchars($row['Usu_nickname']) . "'>";
    
                // Estilizando los campos
                echo "<div class='form-group' style='width: 100%;'>";
                echo "<label for='nombre' style='font-weight: bold;'>Nombre:</label>";
                echo "<input type='text' id='nombre' name='nombre' value='" . htmlspecialchars($row['Usu_nombre']) . "' placeholder='Nombre' required style='width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;'>";
                echo "</div>";
    
                echo "<div class='form-group' style='width: 100%;'>";
                echo "<label for='apellido' style='font-weight: bold;'>Apellido:</label>";
                echo "<input type='text' id='apellido' name='apellido' value='" . htmlspecialchars($row['Usu_apellido']) . "' placeholder='Apellido' required style='width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;'>";
                echo "</div>";
    
                echo "<div class='form-group' style='width: 100%;'>";
                echo "<label for='correo' style='font-weight: bold;'>Correo:</label>";
                echo "<input type='email' id='correo' name='correo' value='" . htmlspecialchars($row['Usu_correo']) . "' placeholder='Correo' required style='width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;'>";
                echo "</div>";
    
                echo "<div class='form-group' style='width: 100%;'>";
                echo "<label for='foto' style='font-weight: bold;'>Actualizar foto:</label>";
                echo "<input type='file' id='foto' name='foto' accept='image/*' style='padding: 5px;'>";
                echo "</div>";
    
                // Botón estilizado
                echo "<button type='submit' style='padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            } 
        }
        else {
              echo "<tr><td colspan='8'>No hay usuarios registrados</td></tr>";
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
