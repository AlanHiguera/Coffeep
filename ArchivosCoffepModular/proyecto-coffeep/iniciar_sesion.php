<?php
if (!empty($_GET['error'])) {
    $error_message = '';
    switch ($_GET['error']) {
        case 'contraseña_incorrecta':
            $error_message = 'La contraseña es incorrecta. Por favor, inténtalo de nuevo☕✨';
            break;
        case 'inactividad':
            $error_message = 'Tu cuenta está inactiva. Por favor, contacta al administrador☕✨';
            break;
        case 'usuario_no_existe':
            $error_message = 'El usuario no existe. Verifica tus credenciales☕✨';
            break;
        default:
            $error_message = 'Ha ocurrido un error desconocido. Por favor, inténtalo de nuevo☕✨';
            break;
    }
    if (!empty($error_message)) {
        echo "
            <div id='mensaje-calificacion'>$error_message</div>
            <script>
                setTimeout(() => {
                    const mensaje = document.getElementById('mensaje-calificacion');
                    if (mensaje) {
                        mensaje.style.transition = 'opacity 0.5s ease';
                        mensaje.style.opacity = '0';
                        setTimeout(() => mensaje.remove(), 500);
                    }
                }, 5000);
            </script>
        ";
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
<style>
#mensaje-calificacion {
    position: fixed;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    padding: 15px;
    background-color: #f8e8d8;
    border: 2px solid #d6b8a9;
    border-radius: 10px;
    color: #a17157;
    font-size: 18px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    text-align: center;
}
</style>
<body>
  <!-- Encabezado -->
  <header>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="guia.php">Infromación</a></li>
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
  <script>
document.addEventListener('DOMContentLoaded', () => {
    // Confirmación para eliminar comentarios
    document.querySelectorAll('form[action=""]').forEach(form => {
        const deleteButton = form.querySelector('button[name="eliminar_comentario"]');
        if (deleteButton) {
            deleteButton.addEventListener('click', (event) => {
                if (!confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
                    event.preventDefault(); // Cancela el envío si el usuario no confirma
                }
            });
        }
    });
});
</script>

</body>

</html>
