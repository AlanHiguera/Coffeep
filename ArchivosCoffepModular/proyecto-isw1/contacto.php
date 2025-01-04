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
  <title>Contacto - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
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

  <!-- Sección de Contacto -->
  <main>
    <div class="contact-container">
      <div class="contact-content">
        <h1>Contáctanos</h1>
        <p>
          En caso de presentar algún inconveniente con la aplicación o quiera reportar algo, 
          envíanos un mensaje al siguiente correo:
        </p>
        <a href="mailto:coffeep.admins@gmail.com">coffeep.admins@gmail.com</a>
        <p class="note">*Recibirá una respuesta en un plazo máximo de 7 días.</p>
      </div>
    </div>
    <div class="logo-container-forms">
        <img src="images/logo_coffee-p.png" alt="Logo Coffee-P">
      </div>
  </main>

  <!-- Pie de página -->
  <footer>
    <p>Coffee-P © Todos los derechos reservados.</p>
  </footer>
</body>
</html>
