<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); // Limpia espacios extra
    $password = $_POST['password'];

    // Preparar consulta para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE Usu_nickname = ?");
    $stmt->bind_param("s", $username); // Vincula el parámetro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar contraseña con password_verify
        if (password_verify($password, $row['Usu_contraseña'])) {
            // Guardar la sesión del usuario
            $_SESSION['user'] = $row['Usu_nickname'];
            $_SESSION['rol'] = $row['Usu_rol']; // Almacenar el rol del usuario

            // Redirigir según el rol
            if ($row['Usu_rol'] == 'Administrador') {
                header("Location: perfil_admin.php");
            } else {
                header("Location: miperfil.php");
            }
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='iniciar_sesion.php';</script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script>alert('Usuario no encontrado.'); window.location.href='iniciar_sesion.php';</script>";
    }
} else {
    // Si no se accede al archivo mediante POST
    header("Location: iniciar_sesion.php");
    exit();
}
?>
