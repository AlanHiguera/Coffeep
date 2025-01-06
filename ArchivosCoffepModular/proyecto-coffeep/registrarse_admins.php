<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener datos del formulario
$nickname = $_POST["username"];
$password = $_POST["password"];
$edad = $_POST["age"];
$nombre = $_POST["firstname"];
$apellido = $_POST["lastname"];
$email = $_POST["email"];

// Ruta de la foto por defecto
$foto_default = 'images/user.png';
$foto_binaria = addslashes(file_get_contents($foto_default));;

// Encriptar la contraseña
//$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el usuario o correo ya existe
$sql_check = "SELECT * FROM usuario WHERE Usu_nickname = '$nickname' OR Usu_correo = '$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "Error: El usuario o correo ya existe.";
} else {
    // Insertar datos en la base de datos si no existe
    $sql_insert = "INSERT INTO usuario (Usu_foto, Usu_nickname, Usu_contraseña, Usu_nombre, Usu_apellido, Usu_correo, Usu_edad, Usu_rol) 
                   VALUES ('$foto_binaria', '$nickname', '$password', '$nombre', '$apellido', '$email', '$edad', 'Administrador')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Registro guardado correctamente.";
        header("location:iniciar_sesion.php");
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}


// Cerrar conexión
$conn->close();
?>