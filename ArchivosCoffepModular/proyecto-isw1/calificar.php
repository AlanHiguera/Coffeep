<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_receta = $_POST['id_receta'];
    $calificacion = $_POST['calificacion'];

    // Validar que la calificación esté en el rango permitido
    if ($calificacion >= 0 && $calificacion <= 5) {
        $sql = "UPDATE receta SET Rec_calificacion = ((Rec_calificacion + ?) / 2) WHERE Rec_idrec = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('di', $calificacion, $id_receta);

        if ($stmt->execute()) {
            header("Location: receta.php?id=$id_receta");
        } else {
            echo "Error al calificar la receta.";
        }
    } else {
        echo "Calificación inválida.";
    }
}
?>
