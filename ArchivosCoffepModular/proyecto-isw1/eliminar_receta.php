<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_receta'])) {
    $id_receta = $conn->real_escape_string($_POST['id_receta']);

    // Verificar que el usuario sea el propietario de la receta
    session_start();
    if (isset($_SESSION['user'])) {
        $nickname = $conn->real_escape_string($_SESSION['user']);
        $query = "DELETE FROM receta WHERE Rec_idrec = '$id_receta' AND Rec_nickname = '$nickname'";
        if ($conn->query($query)) {
            header("Location: mis_recetas.php?msg=receta_eliminada");
            exit();
        } else {
            echo "Error al eliminar la receta: " . $conn->error;
        }
    } else {
        header("Location: iniciar_sesion.php");
        exit();
    }
} else {
    header("Location: mis_recetas.php");
    exit();
}
?>