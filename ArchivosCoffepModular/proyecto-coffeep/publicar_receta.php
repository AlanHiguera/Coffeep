<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_Receta = $_POST['rec_nombre'] ?? null;
    $preparacion = $_POST['rec_preparacion'] ?? null;
    $grano_id = $_POST['rec_grano'] ?? null;
    $metodo = $_POST['rec_metodo'] ?? null;
    $fecha_pub = date('Y-m-d');
    $age_restriction = isset($_POST['rec_clasificacion']) && $_POST['rec_clasificacion'] == '+18' ? '+18' : 'ATP';
    $nickname = $_SESSION['user'] ?? null;
    $calificacion = 0.0;

    // Verificar que los campos obligatorios no estén vacíos
    if (!$nombre_Receta || !$preparacion || !$grano_id || !$metodo || !$nickname) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Manejar la subida de la foto
    $foto_data = null;
    if (isset($_FILES['rec_foto']) && $_FILES['rec_foto']['error'] === UPLOAD_ERR_OK) {
        $foto_tmp = $_FILES['rec_foto']['tmp_name'];
        $foto_data = file_get_contents($foto_tmp); // Leer el contenido del archivo
        if ($foto_data === false) {
            die("Error: No se pudo leer la foto.");
        }
    }

    // Preparar la consulta de inserción
    $sql = "INSERT INTO receta (Rec_nombre, Rec_preparacion, Rec_idgrano, Rec_metodo, Rec_fecha_pub, Rec_clasificacion, Rec_nickname, Rec_calificacion, Rec_foto) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Enlazar los parámetros
    $null = null; // Para la foto binaria
    $stmt->bind_param("ssisssssb", $nombre_Receta, $preparacion, $grano_id, $metodo, $fecha_pub, $age_restriction, $nickname, $calificacion, $null);

    // Enviar los datos binarios de la foto
    if ($foto_data !== null) {
        $stmt->send_long_data(8, $foto_data); // El índice 8 corresponde al noveno parámetro: Rec_foto
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $Receta_id = $stmt->insert_id; // Obtener el ID de la receta recién insertada
        echo "Receta guardada correctamente con ID: " . $Receta_id;

        // Aquí empieza la lógica para manejar los ingredientes y la información nutricional
        if (isset($_POST['ingredientes'], $_POST['cantidades'])) {
            $total_grasas = 0;
            $total_proteinas = 0;
            $total_hidratos = 0;
            $total_azucares = 0;
            $total_sodio = 0;
            $total_colesterol = 0;

            foreach ($_POST['ingredientes'] as $index => $ingrediente_id) {
                $cantidad = $_POST['cantidades'][$index];

                // Insertar ingrediente con cantidad
                $sql_ingrediente = "INSERT INTO cantidad_ingrediente (Can_idrec, Can_iding, Can_cantidad) VALUES (?, ?, ?)";
                $stmt_ingrediente = $conn->prepare($sql_ingrediente);
                if (!$stmt_ingrediente) {
                    die("Error al preparar consulta de ingredientes: " . $conn->error);
                }
                $stmt_ingrediente->bind_param("iid", $Receta_id, $ingrediente_id, $cantidad);
                $stmt_ingrediente->execute();

                // Obtener información nutricional del ingrediente
                $sql_nutricional = "SELECT Inf_grasas, Inf_proteinas, Inf_hidratos, Inf_azucares, Inf_sodio, Inf_colesterol 
                                    FROM info_nutricional WHERE Inf_iding = ?";
                $stmt_nutricional = $conn->prepare($sql_nutricional);
                $stmt_nutricional->bind_param("i", $ingrediente_id);
                $stmt_nutricional->execute();
                $stmt_nutricional->bind_result($grasas, $proteinas, $hidratos, $azucares, $sodio, $colesterol);
                $stmt_nutricional->fetch();
                $stmt_nutricional->close();

                // Calcular valores totales
                $total_grasas += ($grasas * $cantidad) / 100;
                $total_proteinas += ($proteinas * $cantidad) / 100;
                $total_hidratos += ($hidratos * $cantidad) / 100;
                $total_azucares += ($azucares * $cantidad) / 100;
                $total_sodio += ($sodio * $cantidad) / 100;
                $total_colesterol += ($colesterol * $cantidad) / 100;
            }

            // Actualizar receta con valores nutricionales totales
            $sql_update = "UPDATE receta SET Rec_grasas = ?, Rec_proteinas = ?, Rec_hidratos = ?, Rec_azucares = ?, Rec_sodio = ?, Rec_colesterol = ? 
                           WHERE Rec_idrec = ?";
                           
            $stmt_update = $conn->prepare($sql_update);
            if (!$stmt_update) {
                die("Error al preparar consulta de actualización: " . $conn->error);
            }
            $stmt_update->bind_param("ddddddi", $total_grasas, $total_proteinas, $total_hidratos, $total_azucares, $total_sodio, $total_colesterol, $Receta_id);
            $stmt_update->execute();
        }

        echo "Información nutricional calculada y guardada correctamente.";
    } else {
        die("Error en la consulta: " . $stmt->error);
    }

    $_SESSION['mensaje'] = "¡Tu receta ha sido creada! ☕✨";
    header("Location: crear_receta.php");
    exit();

    $stmt->close();
    $conn->close();
}
?>