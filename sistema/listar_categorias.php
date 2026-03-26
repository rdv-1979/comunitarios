<?php
    include './menu.php';
    include '../bd/conectar.php';

    $sql_categorias = mysqli_query($conexion, "SELECT * FROM categoria");

    $resultado = mysqli_num_rows($sql_categorias);

    if($resultado <= 0){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay categorías para mostrar!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }else{ ?>
        <div class="table-responsive mt-3 bg-white p-2 border border-primary border-3">
            <table id="tabla" class="table table-striped table-hover table-dark">
                <thead>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php while($datos = mysqli_fetch_array($sql_categorias)){ ?>
                            <tr>
                                <td><?php echo $datos['id_categoria']; ?></td>
                                <td><?php echo $datos['descripcion_categoria']; ?></td>
                                <td>
                                    <a href="./eliminar_categoria.php?id=<?php echo $datos['id_categoria']; ?>" class="btn btn-danger">Eliminar</a>
                                    |
                                    <a href="./modificar_categoria.php?id=<?php echo $datos['id_categoria']; ?>" class="btn btn-primary">Modificar</a>
                                </td>
                            </tr>
                    <?php } ?>
    <?php }
?>
</tbody>
</table>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar categorías</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>