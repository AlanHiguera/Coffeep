<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Archivo para conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_receta = $_POST['Rec_nombre'];
    $preparacion = $_POST['rec_preparacion'];
    $grano_id = $_POST['rec_grano'];
    $metodo = $_POST['rec_metodo'];
    $age_restriction = isset($_POST['age_restriction']) ? '+18' : 'APT';
    $fecha_pub = date('Y-m-d'); // Fecha de publicación actual
    $nickname = $_SESSION['user']; // Usuario autenticado

    // Verificar que el usuario exista
    $sql_user = "SELECT Usu_nickname FROM usuario WHERE Usu_nickname = '$nickname'";
    $result_user = mysqli_query($conn, $sql_user);

    if (mysqli_num_rows($result_user) == 0) {
        echo "Error: El usuario no existe.";
        exit();
    }

    // Subir imagen
    $foto = null;
    if (isset($_FILES['rec_foto']) && $_FILES['rec_foto']['error'] == UPLOAD_ERR_OK) {
        $file_info = getimagesize($_FILES['rec_foto']['tmp_name']);
        if ($file_info) {
            $foto = addslashes(file_get_contents($_FILES['rec_foto']['tmp_name']));
        } else {
            echo "Error: El archivo subido no es una imagen válida.";
            exit();
        }
    }

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO receta (Rec_nombre, Rec_preparacion, Rec_idgrano, Rec_metodo, Rec_foto, Rec_fecha_pub, Rec_clasificacion, Rec_calificacion, Rec_grasas, Rec_proteinas, Rec_hidratos, Rec_azucares, Rec_sodio, Rec_colesterol, Rec_nickname)
            VALUES ('$nombre_receta', '$preparacion', $grano_id, '$metodo', '$foto', '$fecha_pub', '$age_restriction', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$nickname')";

    if (mysqli_query($conn, $sql)) {
        // Obtener el ID de la receta recién insertada
        $receta_id = mysqli_insert_id($conn);

        // Insertar los ingredientes si están definidos
        if (isset($_POST['ingredientes']) && is_array($_POST['ingredientes'])) {
            foreach ($_POST['ingredientes'] as $ingrediente_id) {
                $sql_ingrediente = "INSERT INTO cantidad_ingrediente (Can_idrec, Can_iding) VALUES ($receta_id, $ingrediente_id)";
                mysqli_query($conn, $sql_ingrediente);
            }
        }

        // Redirigir a una página de confirmación
        header("Location: crear_receta.php?success=1");
        exit();
    } else {
        echo "Error al guardar la receta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
