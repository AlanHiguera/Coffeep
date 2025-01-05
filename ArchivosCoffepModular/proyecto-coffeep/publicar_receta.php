<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}
include 'conexion.php';
include 'subir_foto.php'; // Incluir el archivo con la función subirFoto

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
        echo "nombre_Receta: " . var_export($nombre_Receta, true) . "<br>";
        echo "preparacion: " . var_export($preparacion, true) . "<br>";
        echo "grano_id: " . var_export($grano_id, true) . "<br>";
        echo "metodo: " . var_export($metodo, true) . "<br>";
        echo "nickname: " . var_export($nickname, true) . "<br>";
        echo "calificacion: " . var_export($calificacion, true) . "<br>";
        die("Error: Todos los campos son obligatorios.");
    }

    // Insertar Receta
    $sql = "INSERT INTO receta (Rec_nombre, Rec_preparacion, Rec_idgrano, Rec_metodo, Rec_fecha_pub, Rec_clasificacion, Rec_nickname, Rec_calificacion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssd", $nombre_Receta, $preparacion, $grano_id, $metodo, $fecha_pub, $age_restriction, $nickname, $calificacion);

    if ($stmt->execute()) {
        $Receta_id = $stmt->insert_id;

        // Manejar la subida de la foto
        if (isset($_FILES['rec_foto']) && $_FILES['rec_foto']['error'] == UPLOAD_ERR_OK) {
            if (!subirFoto($_FILES['rec_foto'], $conn, $Receta_id)) {
                die("Error: No se pudo subir la foto.");
            }
        }

        // Insertar ingredientes con cantidades y calcular información nutricional
        $total_grasas = 0;
        $total_proteinas = 0;
        $total_hidratos = 0;
        $total_azucares = 0;
        $total_sodio = 0;
        $total_colesterol = 0;

        foreach ($_POST['ingredientes'] as $index => $ingrediente_id) {
            $cantidad = $_POST['cantidades'][$index];
            $sql_ingrediente = "INSERT INTO cantidad_ingrediente (Can_idrec, Can_iding, Can_cantidad) VALUES (?, ?, ?)";
            $stmt_ingrediente = $conn->prepare($sql_ingrediente);
            $stmt_ingrediente->bind_param("iid", $Receta_id, $ingrediente_id, $cantidad);
            $stmt_ingrediente->execute();

            // Obtener información nutricional del ingrediente
            $sql_nutricional = "SELECT Inf_grasas, Inf_proteinas, Inf_hidratos, Inf_azucares, Inf_sodio, Inf_colesterol FROM info_nutricional WHERE Inf_iding = ?";
            $stmt_nutricional = $conn->prepare($sql_nutricional);
            $stmt_nutricional->bind_param("i", $ingrediente_id);
            $stmt_nutricional->execute();
            $stmt_nutricional->bind_result($grasas, $proteinas, $hidratos, $azucares, $sodio, $colesterol);
            $stmt_nutricional->fetch();
            $stmt_nutricional->close();

            // Calcular la información nutricional total
            $total_grasas += ($grasas * $cantidad) / 100;
            $total_proteinas += ($proteinas * $cantidad) / 100;
            $total_hidratos += ($hidratos * $cantidad) / 100;
            $total_azucares += ($azucares * $cantidad) / 100;
            $total_sodio += ($sodio * $cantidad) / 100;
            $total_colesterol += ($colesterol * $cantidad) / 100;
        }

        // Actualizar la receta con la información nutricional total
        $sql_update = "UPDATE receta SET Rec_grasas = ?, Rec_proteinas = ?, Rec_hidratos = ?, Rec_azucares = ?, Rec_sodio = ?, Rec_colesterol = ? WHERE Rec_idrec = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ddddddi", $total_grasas, $total_proteinas, $total_hidratos, $total_azucares, $total_sodio, $total_colesterol, $Receta_id);
        $stmt_update->execute();

        // Redirigir con éxito
        header("Location: crear_receta.php?success=1");
        exit();
    } else {
        die("Error: No se pudo guardar la receta.");
    }
}
?>