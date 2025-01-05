<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: iniciar_sesion.php");
    exit();
}
include 'conexion.php';
include 'subir_foto.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_Receta = $_POST['rec_nombre'] ?? null;
    $preparacion = $_POST['rec_preparacion'] ?? null;
    $grano_id = $_POST['rec_grano'] ?? null;
    $metodo = $_POST['rec_metodo'] ?? null;
    $fecha_pub = date('Y-m-d');
    $age_restriction = isset($_POST['rec_clasificacion']) && $_POST['rec_clasificacion'] == '+18' ? '+18' : 'ATP';
    $nickname = $_SESSION['nickname'] ?? null;
    $calificacion = 0.0;

    // Manejar la subida de la foto
    $fileTmpPath = null;
    $fileName = null;
    $fileSize = null;
    $fileType = null;
    $fileExtension = null;
    $foto = null;

    if (isset($_FILES['rec_foto']) && $_FILES['rec_foto']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['rec_foto']['tmp_name'];
        $fileName = $_FILES['rec_foto']['name'];
        $fileSize = $_FILES['rec_foto']['size'];
        $fileType = $_FILES['rec_foto']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            die("Error: Solo se permiten archivos JPG, JPEG, PNG y GIF.");
        }

        $foto = file_get_contents($fileTmpPath);
    }

    // Verificar que los campos obligatorios no estén vacíos
    if (!$nombre_Receta || !$preparacion || !$grano_id || !$metodo || !$nickname) {
        echo "nombre_Receta: " . var_export($nombre_Receta, true) . "<br>";
        echo "preparacion: " . var_export($preparacion, true) . "<br>";
        echo "grano_id: " . var_export($grano_id, true) . "<br>";
        echo "metodo: " . var_export($metodo, true) . "<br>";
        echo "nickname: " . var_export($nickname, true) . "<br>";
        echo "calificacion: " . var_export($calificacion, true) . "<br>";
        echo "fileTmpPath: " . var_export($fileTmpPath, true) . "<br>";
        echo "fileName: " . var_export($fileName, true) . "<br>";
        echo "fileSize: " . var_export($fileSize, true) . "<br>";
        echo "fileType: " . var_export($fileType, true) . "<br>";
        echo "fileExtension: " . var_export($fileExtension, true) . "<br>";
        echo "foto (contenido): " . var_export(substr($foto, 0, 100), true) . "...<br>"; // Mostrar solo los primeros 100 caracteres del contenido de la foto
        die("Error: Todos los campos son obligatorios.");
    }

    // Insertar Receta
    $sql = "INSERT INTO receta (Rec_nombre, Rec_preparacion, Rec_idgrano, Rec_metodo, Rec_foto, Rec_fecha_pub, Rec_clasificacion, Rec_nickname, Rec_calificacion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssssd", $nombre_Receta, $preparacion, $grano_id, $metodo, $foto, $fecha_pub, $age_restriction, $nickname, $calificacion);

    if ($stmt->execute()) {
        $Receta_id = $stmt->insert_id;

        // Variables para la información nutricional total
        $total_grasas = 0;
        $total_proteinas = 0;
        $total_hidratos = 0;
        $total_azucares = 0;
        $total_sodio = 0;
        $total_colesterol = 0;

        // Insertar ingredientes con cantidades y calcular información nutricional
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
    }
}
?>