<?php
    include '../bd/conectar.php';
    include './menu.php';

    //relacionar usuarios reportes historial puntos colaboraciones empresas.

    /* $sql_colaboraciones = mysqli_query($conexion, "SELECT u.id_usuario, u.maravilla, u.nombre_u, u.email_u,
                                                   r.descripcion_reporte, r.fecha, r.estado_reporte, r.captura,
                                                   r.observacion_r, c.descripcion_colaboracion, c.fecha_colaboracion
                                                   FROM usuarios u INNER JOIN colaboraciones_empresas c ON u.id_usuario=c.id_empresa_usuario
                                                   INNER JOIN historial_puntos h ON u.id_usuario=h.id_usuario_h
                                                   INNER JOIN reportes r ON r.id_reporte=h.id_reporte_h"); */

    $sql_colaboraciones = mysqli_query($conexion, "SELECT  u.id_usuario,
                                                           u.nombre_u,
                                                           u.email_u,
                                                           u.maravilla,
                                                           c.descripcion_colaboracion,
                                                           c.fecha_colaboracion,
                                                           c.id_colaboracion,
                                                           r.descripcion_reporte,
                                                           r.fecha,
                                                           r.estado_reporte,
                                                           r.captura,
                                                           r.observacion_r
                                                            FROM usuarios u
                                                            INNER JOIN colaboraciones_empresas c
                                                                ON u.id_usuario = c.id_empresa_usuario
                                                            INNER JOIN reportes r
                                                                ON r.id_reporte = c.id_reporte_c");

    $resultado = mysqli_num_rows($sql_colaboraciones);

    //echo $resultado;
    //exit();

    if($resultado > 0){ ?>
        <div class="mb-3">
            <h2>Listado de colaboraciones.</h2>
        </div>
        <div class="table-responsive">
            <table id="tabla" class="table table-hover table-striped table-dark">
                <thead>
                    <th>#</th>
                    <th>Nombre maravilla</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Descripción</th>
                    <th>Fecha reporte</th>
                    <th>Estado</th>
                    <th>Captura</th>
                    <th>Observación</th>
                    <th>Descripción de la colaboración</th>
                    <th>Fecha colaboración</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php while($datos = mysqli_fetch_array($sql_colaboraciones)){ ?>
                            <tr>
                                <td><?php echo $datos['id_usuario']; ?></td>
                                <td><?php echo $datos['maravilla']; ?></td>
                                <td><?php echo $datos['nombre_u']; ?></td>
                                <td><?php echo $datos['email_u']; ?></td>
                                <td><?php echo $datos['descripcion_reporte']; ?></td>
                                <td><?php echo $datos['fecha']; ?></td>
                                <td><?php echo $datos['estado_reporte']; ?></td>
                                <td><img src="<?php echo $datos['captura']; ?>" alt="captura" width="75px;" height="75px;"></td>
                                <td><?php echo $datos['observacion_r']; ?></td>
                                <td><?php echo $datos['descripcion_colaboracion']; ?></td>
                                <td><?php echo $datos['fecha_colaboracion']; ?></td>
                                <td>
                                    <a href="imprimir_colaboracion.php?id=<?php echo $datos['id_colaboracion']; ?>" 
                                       target="_blank"class="btn btn-primary">Imprimir</a>
                                </td>
                            </tr>
                    <?php } ?>
        </div>
    <?php }else{ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay colaboraciones para mostrar!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    </tbody>
    </table>
    </div>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar colaboraciones</title>
    </head>
    <body>
        <script>
            let table = new DataTable('#tabla');
        </script>
    </body>
    </html>