<?php
    include './menu.php';
    include '../bd/conectar.php';

    $sql_estados = mysqli_query($conexion, "SELECT * FROM reporte_estado");

    $resultado = mysqli_num_rows($sql_estados);

    if($resultado <= 0){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay estados de reportes para mostrar!.
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
                    <?php while($datos = mysqli_fetch_array($sql_estados)){ ?>
                            <tr>
                                <td><?php echo $datos['id_estado_reporte']; ?></td>
                                <td><?php echo $datos['descripcion_estado']; ?></td>
                                <td>
                                    <a href="./eliminar_estado.php?id=<?php echo $datos['id_estado_reporte']; ?>" class="btn btn-danger">Eliminar</a>
                                    |
                                    <a href="./modificar_estado.php?id=<?php echo $datos['id_estado_reporte']; ?>" class="btn btn-primary">Modificar</a>
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
    <title>Listar estados</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>