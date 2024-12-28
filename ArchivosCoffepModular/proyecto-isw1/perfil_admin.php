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
  <title>Perfil Admin - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="perfil_admin.css">
  <link rel="icon" href="proyecto-isw1/images/favicon.png">
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
  <main>
    <div class="container">
      <!-- Perfil del Usuario -->
      <div class="sidebar">
        <img src="images/user.png" alt="Perfil">
        <h3>admin.coffep</h3>
        <p>Admin | 24 años</p>
        <p>coffeep.admins@gmail.com</p>
        <a href="#">Editar perfil</a>
      </div>
  
      <!-- Gestión de Tablas -->
      <div class="content">
        <h3>Gestión</h3>
        <a href="crear_receta.php"><button>Crear Receta</button></a>
        <a href="mantenedor_ting.php"><button>Tipo de ingrediente</button></a>
        <a href="generar_listusu.php"><button>Listado de Usuarios</button></a>
        <a href="cerrar_sesion.php"><button>Cerrar Sesión</button></a>
      </div>
    </div>
  </main>

  <footer>
    Coffee-P &copy; Todos los derechos reservados
  </footer>
</body>
</html>
