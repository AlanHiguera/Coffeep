<?php
// obtener_ingredientes.php
function ListadoTipoIngredientes($conexion, $limite = 10) {
    // Asegúrate de que el límite sea un número entero
    $limite = intval($limite);

    // Construye la consulta SQL directamente
    $sql = "SELECT tipo_ingrediente.Tip_idtipo, tipo_ingrediente.Tip_nombre FROM tipo_ingrediente LIMIT $limite";

    // Ejecuta la consulta
    $resultado = $conexion->query($sql);

    if (!$resultado) {
        die("Error en la consulta: " . $conexion->error);
    }

    // Crea un array para almacenar los datos
    $ingredientes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $ingredientes[] = $fila;
    }

    // Devuelve los ingredientes
    return $ingredientes;
}
