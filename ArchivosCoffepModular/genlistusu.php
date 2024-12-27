<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Coffee-P</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.png">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="">Inicio</a></li>
        <li><a href="contacto.html">Contacto</a></li>
      </ul>
      <div class="icons">
        <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></></span>
        <span class="user">
          <a href="registro.html">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;"></a>
          </a>
        </span>
      </div>
    </nav>
  </header>
    <title>Listado de Usuarios</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3e7de;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 300px;
            background-color: #e7d5c7;
            padding: 30px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            font-size: 22px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .sidebar hr {
            border: 0;
            border-top: 2px dashed #333;
            margin-bottom: 30px;
        }

        .sidebar button {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 15px;
            background-color: #b98c75;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .sidebar button:hover {
            background-color: #a0765b;
        }

        .sidebar .active {
            text-decoration: underline;
        }

        .content {
            flex: 1;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #d5a48a;
        }

        th {
            background-color: #d5b5a4;
            font-weight: bold;
        }

        .delete-link {
            color: red;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #7a7a7a;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Generar Listados</h3>
            <hr>
            <button>Recetas</button>
            <button class="active">Usuarios</button>
            <button>Comentarios</button>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>Listado de Usuarios</h1>
            <table>
                <thead>
                    <tr>
                        <th>nickname</th>
                        <th>Correo</th>
                        <th>Nombres</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Gestión</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $usuarios_html = "";  // Asegúrate de definirlo aquí
                        include 'conexion.php';

                        // Query para obtener usuarios
                        $sql_check = "SELECT Usu_nickname, Usu_correo, Usu_nombre, Usu_apellido, Usu_edad FROM usuario ORDER BY Usu_nickname ASC;";
                        $result = $conn->query($sql_check);
                        
                        
                        // Generar el HTML con los resultados de la consulta
                        if ($result->num_rows > 0) {
                            // Imprimir filas de la tabla
                            while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['Usu_nickname'] . "</td>";
                            echo "<td>" . $row['Usu_correo'] . "</td>";
                            echo "<td>" . $row['Usu_nombre'] . "</td>";
                            echo "<td>" . $row['Usu_apellido'] . "</td>";
                            echo "<td>" . $row['Usu_edad'] . "</td>";
                            echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No hay usuarios registrados</td></tr>";
                        }
                        
                        $conn->close();
                    ?>
                </tbody>
            </table>

            <div class="footer">
                Coffee-P © Todos los derechos reservados
            </div>
        </div>
    </div>
</body>
</html>