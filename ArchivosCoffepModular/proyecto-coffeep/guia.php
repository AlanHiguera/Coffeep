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
  <title>Información - Coffee-P</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="guia_estilo.css">
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
        </span>
      </div>
    </nav>
  </header>

<main>
    <div class="accordion-container">
        <h2 style="text-align: center;">Guía de infromación</h2>
        <div class="accordion-item">
            <div class="accordion-header">Medidas y conversiones</div>
            <div class="accordion-content">
            <p>Conoce las conversiones básicas para cocinar: </p>
            <ul>
                <li>1 cucharada = 10 g</li>
                <li>1 g = 1 ml (en agua)</li>
                <li>1 taza = 240 ml</li>
                <li>1 cucharadita = 5 g</li>
            </ul>
            <p>Este conocimiento te ayudará a seguir recetas con mayor precisión.</p>
            </div>
        </div>
        <div class="accordion-item">
            <div class="accordion-header">Guía de Uso</div>
            <div class="accordion-content">
            <p>Para usar nuestra aplicación, primero inicia sesión y crea tus recetas. Explora las recetas de otros usuarios y comparte comentarios o sugerencias.</p>
            </div>
        </div>
        <div class="accordion-item">
            <div class="accordion-header">Normas Básicas</div>
            <div class="accordion-content">
            <p><strong>Normas al publicar recetas y comentarios:</strong></p>
            <ul>
                <li>Respeta las normas de convivencia: evita comentarios ofensivos.</li>
                <li>No publiques contenido inapropiado o que viole derechos de autor.</li>
                <li>Incluye descripciones claras y precisas en tus recetas.</li>
                <li>Revisa bien tus datos antes de publicar.</li>
            </ul>
            </div>
        </div>
    </div>
</main>

<!-- Pie de página -->
<footer>
  <p>Coffee-P © Todos los derechos reservados.</p>
</footer>

<script>
  // Lógica para los desplegables
  document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
      const content = header.nextElementSibling;
      const isOpen = content.style.display === 'block';

      // Cierra todos los demás
      document.querySelectorAll('.accordion-content').forEach(c => c.style.display = 'none');

      // Abre o cierra el contenido seleccionado
      content.style.display = isOpen ? 'none' : 'block';
    });
  });
</script>

</body>
</html>