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
        <li><a href="guia.php">Información</a></li>
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
            <th>Foto</th>
            <th>Nickname</th>
            <th>Correo</th>
            <th>Nombre</th>
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
        $sql_check = "SELECT * FROM usuario";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            // Imprimir filas de la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                
                // Codificar la imagen en base64
                $imageData = base64_encode($row['Usu_foto']);
                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                
                // Mostrar la imagen
                echo "<td> <img src='" . $imageSrc . "' alt='' style='width: 50px;height:50px;' /> </td>";
                
                // Mostrar los datos del usuario
                echo "<td>" . $row['Usu_nickname'] . "</td>";
                echo "<td>" . $row['Usu_correo'] . "</td>";
                echo "<td>" . $row['Usu_nombre'] . "</td>";
                echo "<td>" . $row['Usu_apellido'] . "</td>";
                echo "<td>" . $row['Usu_rol'] . "</td>";
                echo "<td><a class='edit' href='#" . $row['Usu_nickname'] . "'>Editar</a></td>";
                echo "<td><a class='delete' href='#" . $row['Usu_nickname'] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay usuarios registrados</td></tr>";
        }

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