<?php
require_once('conexion.php');
$d = new Dato();

// Verificar si se ha proporcionado un id en la URL
if(!isset($_GET['id'])){
    die('Error: No se ha proporcionado el ID del producto.');
}

// Obtener los datos del producto por ID
$producto = $d->getDatas("SELECT * FROM producto WHERE id='" . $_GET['id'] . "';");

// Verificar si el producto existe
if (count($producto) > 0) {
    $producto = $producto[0]; // Tomamos el primer elemento
} else {
    die('Error: Producto no encontrado.');
}

// Si el formulario ha sido enviado
if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['categoria_id'])) {
    $mensaje = "";
    // Validación de nombre (no puede estar vacío)
    if (empty($_POST['nombre'])) {
        $mensaje .= 'El campo nombre es nulo. ';
    }
    // Validación de precio (no puede estar vacío y debe ser un número)
    if (empty($_POST['precio']) || !is_numeric($_POST['precio'])) {
        $mensaje .= 'El campo precio es inválido. ';
    }

    // Si no hay errores, actualizar el producto en la base de datos
    if (empty($mensaje)) {
        // Consulta SQL usando parámetros preparados para evitar inyecciones SQL
        $sql = "UPDATE producto SET categoria_id = :categoria_id, nombre = :nombre, precio = :precio WHERE id = :id";

        // Prepara la consulta usando el método getConnection()
        $stmt = $d->getConnection()->prepare($sql);

        // Asocia los valores con los parámetros de la consulta
        $stmt->bindParam(':categoria_id', $_POST['categoria_id']);
        $stmt->bindParam(':nombre', $_POST['nombre']);
        $stmt->bindParam(':precio', $_POST['precio']);
        $stmt->bindParam(':id', $_GET['id']); // Asegúrate de actualizar el producto con el id correcto

        // Ejecuta la consulta
        $stmt->execute();
        // Redirige si la actualización fue exitosa
        header('Location: edit.php?id=' . $_GET['id'] . '&success=1');
        exit();
    } else {
        echo $mensaje; // Mostrar mensajes de error si los hay
    }
} else {
    // Si no se ha enviado el formulario, obtener las categorías
    $categorias = $d->getDatas("SELECT * FROM categorias;");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container">
    <div class="card border-primary mb-3">
        <div class="card-header bg-primary text-white">
            <h1>Editar Producto</h1>
        </div>
        <div class="card-body text-primary">
            <!-- Mostrar mensajes de error o éxito -->
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">Error: <?php echo $_GET['error']; ?></div>
            <?php endif; ?>
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success">Producto actualizado con éxito.</div>
            <?php endif; ?>

            <!-- Formulario de edición -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="categoria_id">Categoría</label>
                    <select name="categoria_id" id="categoria_id" class="form-control">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>"
                                <?php echo $categoria['id'] == $producto['categoria_id'] ? 'selected' : ''; ?>>
                                <?php echo $categoria['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required/>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" name="precio" id="precio" value="<?php echo $producto['precio']; ?>" required/>
                </div>
                <hr/>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
