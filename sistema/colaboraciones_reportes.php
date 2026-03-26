<?php
    include '../bd/conectar.php';
    include './menu.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id']; 

        $sql_listar_reportes = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                        INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria");

        $resultado = mysqli_num_rows($sql_listar_reportes);

        if($resultado <= 0){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> No hay reportes para mostrar.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
                <div class="table-responsive bg-white p-2 border border-primary border-3">
                    <div class="mb-3">
                        <h2>Listado de reportes</h2>
                    </div>
                    <table id="tabla" class="table table-striped table-hover table-dark">
                        <thead>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                        <?php while($datos = mysqli_fetch_array($sql_listar_reportes)){ ?>
                                <tr>
                                    <td><?php echo $datos['id_reporte']; ?></td>
                                    <td><?php echo $datos['nombre_u']; ?></td>
                                    <td><?php echo $datos['email_u']; ?></td>
                                    <td><?php echo $datos['descripcion_categoria']; ?></td>
                                    <td><?php echo $datos['descripcion_reporte']; ?></td>
                                    <td><?php echo $datos['latitud']; ?></td>
                                    <td><?php echo $datos['longitud']; ?></td>
                                    <td><?php echo $datos['fecha']; ?></td>
                                    <td><?php echo $datos['estado_reporte']; ?></td>
                                    <td><img src="<?php echo $datos['foto']; ?>" alt="imagen" width="50px" height="50px;"></td>
                                    <td>
                                        <?php if($datos['estado_reporte'] != 'resuelto'){ ?>
                                            <a href="colaborar_reporte.php?id_u=<?php echo $id; ?>&id_r=<?php echo $datos['id_reporte']; ?>" class="btn btn-primary">Colaborar</a>
                                        <?php } else { ?>
                                               <span class="badge text-bg-primary" style="font-size:18px;">Resuelto ✔</span> 
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } ?>
        <?php } }

?>
</tbody>
</table>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar reportes a colaborar</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>