<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Conexión a la base de datos

// Obtén información actualizada del usuario
$nickname = $_SESSION['user'];
// Verificar si el usuario existe
$sql = "SELECT * FROM usuario WHERE Usu_nickname = '$nickname'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $age = $row['Usu_edad'];
    $email = $row['Usu_correo'];
    $firstname = $row['Usu_nombre'];
    $lastname = $row['Usu_apellido'];

} else {
    echo "Error al cargar el perfil.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Usuario - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="perfiles.css">
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
          <a href="miperfil.php">
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
        <h3><?php echo $_SESSION['user']; ?></h3>
        <p><?php echo $firstname; ?> <?php echo $lastname; ?> | <?php echo $age; ?></p>
        <p><?php echo $email; ?></p>
        <a href="#">Editar perfil</a>
      </div>
  
      <!-- Opciones de Usuario -->
      <div class="content">
        <h3>Opciones</h3>
        <a href="crear_receta.php"><button>Crear Receta</button></a>
        <a href="recetas_guardadas.php"><button>Recetas Guardadas</button></a>
        <a href="mis_recetas.php"><button>Mis Recetas</button></a>
        <a href="cerrar_sesion.php"><button>Cerrar Sesión</button></a>
      </div>
    </div>
  </main>

  <footer>
    Coffee-P &copy; Todos los derechos reservados
  </footer>
</body>
</html>
