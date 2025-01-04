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
      </ul>
      <div class="icons">
        <span class="bell"><img src="images/bell.png" style="width: 40px; height: 40px;"></span>
        <span class="user">
        <?php 
        session_start();
        if (isset($_SESSION['user'])): 
          // Redirige según el rol
          if ($_SESSION['rol'] == 'Usuario'): ?>
            <a href="perfil_admin.php">
              <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
            </a>
          <?php else: ?>
            <a href="miperfil.php">
              <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
            </a>
          <?php endif; 
          else: ?>
          <a href="registro.html">
            <img src="images/user.png" alt="Inicio" style="width: 40px; height: 40px;">
          </a>
        <?php endif; ?>
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
          <div class="form-group text-right">
            <p><a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a></p>
          </div>
          <button type="submit">Ingresar</button>
        </form>
        <p>¿Aún no tienes una cuenta? <a href="registro.html">Regístrate</a></p>
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
