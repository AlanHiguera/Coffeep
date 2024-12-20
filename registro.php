<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener datos del formulario
$nickname = $_POST["username"];
$password = $_POST["password"];
$edad = $_POST["age"];
$nombre = $_POST["fullname"];
$email = $_POST["email"];

// Encriptar la contraseña
//$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el usuario o correo ya existe
$sql_check = "SELECT * FROM usuario WHERE Usu_nickname = '$nickname' OR Usu_correo = '$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "Error: El usuario o correo ya existe.";
} else {
    // Insertar datos en la base de datos si no existe
    $sql_insert = "INSERT INTO usuario (Usu_nickname, Usu_contraseña, Usu_nombre, Usu_correo, Usu_edad, Usu_rol) 
                   VALUES ('$nickname', '$password', '$nombre', '$email', '$edad', 'usuario')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Registro guardado correctamente.";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>