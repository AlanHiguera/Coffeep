<?php
$error_message = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] === "usuario_no_existe") {
        $error_message = "El usuario no existe. Por favor, regístrate.";
    } elseif ($_GET['error'] === "contraseña_incorrecta") {
        $error_message = "La contraseña es incorrecta. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - Coffee-P</title>
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
            <li><a href="guia.php">Información</a></li>
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

  <!-- Contenido principal -->
  <main>
      <div class="form-container">
          <div class="form-content">
              <h1>Iniciar Sesión</h1>
              <form method="POST" action="crear_sesion.php">
                  <div class="form-group">
                      <label for="username">Nombre de usuario</label>
                      <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
                  </div>
                  <div class="form-group">
                      <label for="password">Contraseña</label>
                      <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                  </div>
                  <?php if (!empty($error_message)): ?>
                    <p class="error-message" style="color: red;"><?= $error_message ?></p>
                <?php endif; ?>
                  <button type="submit"><b>Ingresar</b></button>
              </form>
              <p>¿Aún no tienes una cuenta? <a href="registro.php">Regístrate</a></p>
          </div>
      </div>
      <div class="logo-container-forms">
        <img src="images/logo_coffee-p.png" alt="Logo Coffee-P" class="logo">
      </div>
  </main>

  <!-- Pie de página -->
  <footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
  </footer>
</body>
</html>