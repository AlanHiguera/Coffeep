<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="proyecto-isw1/images/favicon.png">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f3ee;
    }

    header {
      background-color: #d8c3a5;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 15px;
      padding: 0;
      margin: 0;
    }

    nav ul li a {
      text-decoration: none;
      color: #000;
      font-weight: bold;
    }

    .icons {
      display: flex;
      gap: 10px;
    }

    .container {
      padding: 20px;
    }

    .table-container {
      margin: 20px auto;
      width: 90%;
      background-color: #eae7dc;
      padding: 20px;
      border-radius: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      text-align: left;
      padding: 12px;
      border: 1px solid #d8c3a5;
    }

    th {
      background-color: #d8c3a5;
    }

    td a {
      text-decoration: none;
      font-weight: bold;
    }

    td a.edit {
      color: #1a73e8;
    }

    td a.delete {
      color: #b33030;
    }

    footer {
      text-align: center;
      padding: 10px;
      background-color: #d8c3a5;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <!-- Encabezado -->
  <header>
    <nav>
      <ul>
        <li><a href="">Inicio</a></li>
        <li><a href="contacto.html">Contacto</a></li>
      </ul>
      <div class="icons">
        <span class="bell"><img src="proyecto-isw1/images/bell.png" style="width: 40px; height: 40px;"></span>
        <span class="user">
          <a href="registro.html">
            <img src="proyecto-isw1/images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
          </a>
        </span>
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
            $sql_check = "SELECT Usu_nickname, Usu_correo , Usu_nombre, Usu_apellido, Usu_rol FROM usuario";
            $result = $conn->query($sql_check);

            if ($result->num_rows > 0) {
                // Imprimir filas de la tabla
                while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Usu_nickname'] . "</td>";
                echo "<td>" . $row['Usu_correo'] . "</td>";
                echo "<td>" . $row['Usu_nombre'] . "</td>";
                echo "<td>" . $row['Usu_apellido'] . "</td>";
                echo "<td>" . $row['Usu_rol'] . "</td>";
                echo "<td><a class='edit' href='editar_usuario.php?id=" . $row['Usu_nickname'] . "'>Editar</a></td>";
                echo "<td><a class='delete' href='eliminar_usuario.php?id=" . $row['Usu_nickname'] . "'>Eliminar</a></td>";
                echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay usuarios registrados</td></tr>";
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