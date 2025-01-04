<?php

session_start();
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener datos del formulario
$nickname = $_POST["username"];
$password = $_POST["password"];

// Verificar si el usuario existe
$sql_check = "SELECT * FROM usuario WHERE Usu_nickname = '$nickname'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // El usuario existe, verificar la contraseña
    $row = $result->fetch_assoc();

    $_SESSION['user'] = $row['Usu_nickname'];
    $_SESSION['age'] = $row['Usu_edad'];
    $_SESSION['email'] = $row['Usu_correo'];
    $_SESSION['firstname'] = $row['Usu_nombre'];
    $_SESSION['lastname'] = $row['Usu_apellido'];

    if ($row['Usu_contraseña'] === $password) {
        // Contraseña correcta, iniciar sesión
        echo "Inicio de sesión exitoso.";
        // Redirigir a la página principal o dashboard
        if (trim($row['Usu_rol']) === 'Administrador'){
            header("Location: perfil_admin.php");
        }
        else{
            header("Location: miperfil.php");
        }
        exit();
    } else {
        // Contraseña incorrecta
        echo "Error: Contraseña incorrecta.";
    }
} else {
    // Usuario no existe
    echo "Error: El usuario no existe.";
}

// Cerrar conexión
$conn->close();
?>