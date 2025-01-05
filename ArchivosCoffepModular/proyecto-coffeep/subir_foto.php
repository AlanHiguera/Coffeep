<?php
function subirFoto($archivo, $conexion, $recetaId) {
    if (isset($archivo) && $archivo['error'] == UPLOAD_ERR_OK) {
        $rutaTemporal = $archivo['tmp_name'];
        $contenidoFoto = file_get_contents($rutaTemporal);
        
        // Preparar la consulta para insertar la imagen en la base de datos
        $query = "UPDATE receta SET Rec_foto = ? WHERE Rec_idrec = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("bi", $contenidoFoto, $recetaId);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // La imagen se guardó correctamente
        } else {
            return false; // Hubo un error al guardar la imagen
        }
    }
    return null; // No se subió foto
}
?>