<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Coffee-P</title>
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
          display: flex;
          padding: 20px;
      }

      .sidebar {
          background-color: #eae7dc;
          padding: 15px;
          width: 25%;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }

      .sidebar h3 {
          font-size: 18px;
          margin-bottom: 15px;
      }

      .sidebar-button {
          background-color: #d8c3a5;
          border: none;
          color: #000;
          padding: 10px 15px;
          width: 100%;
          margin-bottom: 10px;
          cursor: pointer;
          font-size: 14px;
      }

      .content {
          flex-grow: 1;
          background-color: #fff;
          padding: 20px;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }

      .table-container {
          overflow-x: auto;
      }

      table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #d8c3a5;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #eae7dc;
    font-weight: bold;
}

table td {
    background-color: #fff;
}

table td a {
    text-decoration: none;
    font-weight: bold;
}

table td a:hover {
    text-decoration: underline;
}

.add-link {
    display: block;
    margin-top: 10px;
    text-decoration: none;
    font-weight: bold;
    color: #000;
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
        <div class="sidebar">
            <h3>Mantener tablas</h3>
            <button class="sidebar-button">Variedad de grano</button>
            <button class="sidebar-button">Tipo de ingrediente</button>
        </div>

        <div class="content">
            <div class="table-container">
        <?php
        include 'conexion.php';
        include 'listado_tipo_ing.php'; // Archivo con la función ListadoTipoIngredientes

        // Obtener los ingredientes desde la base de datos
        $ingredientes = ListadoTipoIngredientes($conn, 10); // Limitar a 10 registros

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
        
        // Generar filas de la tabla con los datos obtenidos
        if (!empty($ingredientes)) {
            foreach ($ingredientes as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["Tip_idtipo"]) . '</td>';
                echo '<td id="name-' . htmlspecialchars($row["Tip_idtipo"]) . '">' . htmlspecialchars($row["Tip_nombre"]) . '</td>';
                echo '<td>
                        <button onclick="mostrarFormulario(\'' . htmlspecialchars($row["Tip_idtipo"]) . '\')">Editar</button>
                      </td>';
                echo '<td><a href="eliminar.php?id=' . urlencode($row["Tip_idtipo"]) . '" style="color: red; text-decoration: none;" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')">Eliminar</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No se encontraron resultados.</td></tr>';
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
                
                <!-- Formulario para agregar (sin cambios) -->
        <div id="formulario">
            <form name="nombre" method="POST" action="agregaring.php" onsubmit="return procesarFormulario(event);">
                <label for="nombre">Nombre del ingrediente:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ejemplo: Azúcar" required>
                <button type="submit">Guardar</button>
            </form>
            <p id="mensaje" style="margin-top: 10px; font-weight: bold;"></p>
        </div>
                
        <script>
            // Función para mostrar el formulario de edición
            function mostrarFormulario(id) {
                const form = document.getElementById('edit-form');
                const idInput = document.getElementById('edit-id');
                const nombreInput = document.getElementById('edit-nombre');
                const currentName = document.getElementById(`name-${id}`).textContent;
                idInput.value = id;
                nombreInput.value = currentName;
                form.style.display = 'block';
            }
                
            // Función para ocultar el formulario
            function ocultarFormulario() {
                document.getElementById('edit-form').style.display = 'none';
            }
            // Función para procesar la edición
            function procesarEdicion(event) {
                event.preventDefault();
                
                const formData = new FormData(event.target);
                const mensaje = document.getElementById('edit-mensaje');
                const id = formData.get('id');
                const nuevoNombre = formData.get('nombre');
                
                fetch('editar_tipoing.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes("Exitoso")) {
                        mensaje.textContent = "Nombre actualizado con éxito.";
                        mensaje.style.color = "green";
                        document.getElementById(`name-${id}`).textContent = nuevoNombre;
                        setTimeout(() => ocultarFormulario(), 2000);
                    } else {
                        mensaje.textContent = "Error al actualizar: " + data;
                        mensaje.style.color = "red";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    mensaje.textContent = "Hubo un error al procesar la solicitud.";
                    mensaje.style.color = "red";
                });
            }
                
                    // Función para procesar el agregar (sin cambios)
            function procesarFormulario(event) {
                event.preventDefault(); // Evitar el envío tradicional del formulario
                
                const form = event.target;
                const formData = new FormData(form);
                const mensaje = document.getElementById('mensaje');
                
                fetch('agregaring.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Leer la respuesta del servidor como texto
                .then(data => {
                    mensaje.textContent = data; // Mostrar la respuesta en el mensaje
                    if (data.includes("Registro guardado correctamente")) {
                         mensaje.style.color = "green";
                
                                // Recargar la página después de 2 segundos
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        mensaje.style.color = "red";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    mensaje.textContent = "Hubo un error al procesar el formulario.";
                    mensaje.style.color = "red";
                });
                
                return false; // Prevenir el envío normal del formulario
            }
        </script>
    </div>
</body>
<footer>
    Coffee-P &copy; Todos los derechos reservados
</footer>
                