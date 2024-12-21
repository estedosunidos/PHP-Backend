<?php
require_once('conexion.php');
$d = new Dato();

// Verificar que 'id' esté presente en la URL
if(!isset($_GET['id'])) {
    die("Error: ID no especificado");
}

// Sanitizar el valor del id
$id = (int)$_GET['id'];  // Asegurarse de que el id sea un número entero

// Crear una consulta SQL segura utilizando parámetros preparados
$sql = "DELETE FROM producto WHERE id = :id";
$stmt = $d->getConnection()->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de productos si la eliminación fue exitosa
    header("Location: producto.php");
    exit(); // Asegúrate de detener la ejecución después de redirigir
} else {
    // Mostrar un mensaje de error si no se pudo eliminar el producto
    echo "Error al eliminar el producto.";
}
?>
