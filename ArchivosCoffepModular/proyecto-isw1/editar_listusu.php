<?php
// Iniciar sesión
session_start();

// Recuperar el rol del usuario desde la sesión
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// Conexión a la base de datos
include "conexion.php";

// Verificar si el formulario se envió (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores enviados desde el formulario
    $nickname = $_POST['nickname'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_data = file_get_contents($foto_tmp); // Leer el contenido del archivo
        $foto = $conn->real_escape_string($foto_data); // Escapar los datos binarios
    }
    // Asegurarse de que las variables estén limpias para evitar inyecciones SQL
    $nickname = $conn->real_escape_string($nickname);
    $nombre = $conn->real_escape_string($nombre);
    $apellido = $conn->real_escape_string($apellido);
    $correo = $conn->real_escape_string($correo);   
    if ($foto !== null) {
        // Si se ha cargado una foto, incluirla en la consulta
        $sql_update = "UPDATE usuario SET Usu_nombre = '$nombre', Usu_apellido = '$apellido', Usu_correo = '$correo', Usu_foto = '$foto' WHERE Usu_nickname = '$nickname'";
    } else {
        // Si no se ha cargado una foto, no actualizarla
        $sql_update = "UPDATE usuario SET Usu_nombre = '$nombre', Usu_apellido = '$apellido', Usu_correo = '$correo' WHERE Usu_nickname = '$nickname'";
    }

    // Ejecutar la actualización
    if ($conn->query($sql_update)) {
        // Redirigir según el rol del usuario
        if ($rol === 'Administrador') {
            header("Location: generar_listusu.php?msg=Estado cambiado a $nuevo_estado");
        } else {
            header("Location: editar_perfil.php?msg=Estado cambiado a $nuevo_estado");
        }
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>