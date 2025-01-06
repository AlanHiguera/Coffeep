<?php
function subirFoto($file, $conn, $Receta_id) {
    // Comprobar si el archivo es una imagen
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        return false; // No es una imagen válida
    }

    // Leer el contenido del archivo
    $fotoContenido = file_get_contents($file['tmp_name']);

    // Preparar la consulta para actualizar la foto en la tabla receta
    $sql = "UPDATE receta SET Rec_foto = ? WHERE Rec_idrec = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("bi", $fotoContenido, $Receta_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        return true; // Foto subida correctamente
    } else {
        return false; // Error al subir la foto
    }
}
?>
