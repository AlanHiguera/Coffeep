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
        <h1>Registro</h1>
        <form name="Nuevo Usuario" method="POST" action="registrarse.php">
          <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
          </div>
          <div class="form-group">
            <label for="age">Edad</label>
            <input type="number" id="age" name="age" min="16" max="100" placeholder="Ingrese su edad">
          </div>
          <div class="form-group">
            <label for="fullname">Nombre</label>
            <input type="text" id="firstname" name="firstname" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group">
            <label for="fullname">Apellido</label>
            <input type="text" id="lastname" name="lastname" placeholder="Ingrese su apellido">
          </div>
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@gmail.com">
          </div>
          <button type="submit"><b>Registrarse</b></button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="iniciar_sesion.php">Iniciar Sesión</a></p>
      </div>
    </div>
    <div class="logo-container-forms">
      <img src="images/logo_coffee-p.png" alt="Logo Coffee-P">
    </div>
  </main>

  <!-- Pie de página -->
  <footer>
    <p>Coffee-P &copy; Todos los derechos reservados.</p>
  </footer>
</body>
</html>
