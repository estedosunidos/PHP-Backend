<?php
require_once('conexion.php');
$d = new Dato();

if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['categoria_id'])) {
    $mensaje = "";
    // Validación de nombre (no puede estar vacío)
    if (empty($_POST['nombre'])) {
        $mensaje .= 'El campo nombre es nulo. ';
    }
    // Validación de precio (no puede estar vacío y debe ser un número)
    if (empty($_POST['precio']) || !is_numeric($_POST['precio'])) {
        $mensaje .= 'El campo precio es inválido. ';
        header('Location:add.php?error=1');
        exit();  
    }
    // Si no hay errores, insertar en la base de datos
    if (empty($mensaje)) {
        // Consulta SQL usando parámetros preparados para evitar inyecciones SQL
        $sql = "INSERT INTO producto (categoria_id, nombre, precio) 
                VALUES (:categoria_id, :nombre, :precio)";
        // Prepara la consulta usando el método getConnection()
        $stmt = $d->getConnection()->prepare($sql);
        // Asocia los valores con los parámetros de la consulta
        $stmt->bindParam(':categoria_id', $_POST['categoria_id']);
        $stmt->bindParam(':nombre', $_POST['nombre']);
        $stmt->bindParam(':precio', $_POST['precio']);
        // Ejecuta la consulta
        $stmt->execute();
        // Redirige si la inserción fue exitosa
        header('Location:producto.php?success=1');
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>
<div class="container">
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">
                <h1>ADD</h1>

            </div>
            <div class="card-body text-primary">
                <form action="" method='POST' name='form'>
                <div class="mb-3">
                    <label for="categoria_id">Categoria</label>
                    <select name="categoria_id" id="categoria_id" class="form-control">
                        <?php
                            foreach($categorias as $categoria){
                                ?>
                                    <option value="<?php echo $categoria['id'];?>"><?php
                                    echo $categoria['nombre'];?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name='nombre' id='nombre' required='true'/>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" name='precio' id='precio' required='true'/>
                </div>
                <hr/>
                <a href="javascript:void(0);" onclick='document.form.submit();' class="btn btn-primary">Submit</a>

                </form>
      
            </div>

        </div>
    </div>
</body>
</html>