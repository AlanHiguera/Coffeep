<?php
session_start();

// Redirige al login si no hay sesión activa
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['user']; ?></h1>
    <?php
        header("Location: perfil_admin.php");
        exit();
    ?>
</body>
</html>