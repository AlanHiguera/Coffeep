<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php"); // Redirige al inicio de sesión si no está autenticado
    exit();
}

include 'conexion.php'; // Archivo para conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_receta = $_POST['rec_nombre'];
    $preparacion = $_POST['rec_preparacion'];
    $grano_id = $_POST['rec_grano'];
    $metodo = $_POST['rec_metodo'];
    $age_restriction = isset($_POST['age_restriction']) ? '+18' : 'APT';
    $fecha_pub = date('Y-m-d'); // Fecha de publicación actual
    $nickname = $_SESSION['user']; // Asegúrate de que este usuario exista en la tabla `usuario`

    // Verificar que el usuario exista
    $sql_user = "SELECT Usu_nickname FROM usuario WHERE Usu_nickname = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $nickname);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows == 0) {
        echo "Error: El usuario no existe.";
        exit();
    }

    // Subir imagen
    $foto = NULL;
    if (isset($_FILES['rec_foto']) && $_FILES['rec_foto']['error'] == UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['rec_foto']['tmp_name']);
    }

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO receta (Rec_nombre, Rec_preparacion, Rec_idgrano, Rec_metodo, Rec_foto, Rec_fecha_pub, Rec_clasificacion, Rec_calificacion, Rec_grasas, Rec_proteinas, Rec_hidratos, Rec_azucares, Rec_sodio, Rec_colesterol, Rec_nickname) VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssss", $nombre_receta, $preparacion, $grano_id, $metodo, $foto, $fecha_pub, $age_restriction, $nickname);

    if ($stmt->execute()) {
        // Redirigir a una página de confirmación
        header("Location: crear_receta.php?success=1");
        exit();
    } else {
        echo "Error al guardar la receta: " . $stmt->error;
    }

    // Insertar los ingredientes
    $receta_id = $stmt->insert_id;
    foreach ($_POST['ingredientes'] as $ingrediente_id) {
        $sql_ingrediente = "INSERT INTO receta_ingredientes (receta_id, ingrediente_id) VALUES (?, ?)";
        $stmt_ingrediente = $conn->prepare($sql_ingrediente);
        $stmt_ingrediente->bind_param("ii", $receta_id, $ingrediente_id);
        $stmt_ingrediente->execute();
    }

    $stmt->close();
    $conn->close();
}
?>