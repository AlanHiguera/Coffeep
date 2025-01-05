<?php
session_start();
include 'conexion.php';

$nickname = $_POST["username"];
$password = $_POST["password"];

$sql_check = "SELECT * FROM usuario WHERE Usu_nickname = '$nickname'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['user'] = $row['Usu_nickname'];
    $_SESSION['age'] = $row['Usu_edad'];
    $_SESSION['email'] = $row['Usu_correo'];
    $_SESSION['firstname'] = $row['Usu_nombre'];
    $_SESSION['lastname'] = $row['Usu_apellido'];

    if ($row['Usu_contraseña'] === $password) {
        if (trim($row['Usu_rol']) === 'Administrador') {
            header("Location: perfil_admin.php");
        } else {
            header("Location: miperfil.php");
        }
        exit();
    } else {
        // Redirigir con error de contraseña
        header("Location: iniciar_sesion.php?error=contraseña_incorrecta");
        exit();
    }
} else {
    // Redirigir con error de usuario no encontrado
    header("Location: iniciar_sesion.php?error=usuario_no_existe");
    exit();
}

$conn->close();
?>
