<?php
require_once('conexion.php');
$d = new Dato();

// Corrected method name to 'getDatas' and fixed the SQL query
$datos = $d->getDatas("SELECT producto.id,producto.nombre,producto.precio,producto.categoria_id, categorias.nombre AS categoria FROM producto INNER JOIN categorias ON categorias.id = producto.categoria_id ORDER BY producto.id DESC");

// Print the fetched data
//print_r($datos);
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
                <h1>PHP PDO</h1>

            </div>
            <div class="card-body text-primary">
                <p>
                    <a href="add.php" class="btn btn-success">Add</a>
                </p>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($datos as $dato){
                                ?>
                                  <tr>
                                      <td><?php echo $dato['id']; ?> </td>
                                      <td><?php echo $dato['categoria']; ?> </td>
                                      <td><?php echo $dato['nombre']; ?> </td>
                                      <td><?php echo $dato['precio']; ?> </td>
                                      <td>
                                         <a href="edit.php?id=<?php echo $dato['id']; ?> ">Edit</a>
                                         <a  href="delete.php?id=<?php echo $dato['id']; ?> ">Delete</a>

                                        </td>
                                  </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>

            </div>

        </div>
    </div>
    
</body>
</html>
