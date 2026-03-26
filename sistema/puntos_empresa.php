<?php
    include '../bd/conectar.php';
    include './menu.php';

    $ID = $_SESSION['IDusuario'];
    $tipo = $_SESSION['tipo'];

    if($tipo == 'municipio'){
        $sql_puntos_vecinos = mysqli_query($conexion, "SELECT DISTINCT u.id_usuario, u.nombre_u, r.descripcion_reporte, c.descripcion_colaboracion, h.puntos_h FROM usuarios u LEFT JOIN historial_puntos h 
                                                   ON u.id_usuario=h.id_usuario_h
                                                   LEFT JOIN colaboraciones_empresas c ON u.id_usuario=c.id_empresa_usuario
                                                   LEFT JOIN reportes r ON c.id_reporte_c=r.id_reporte
                                                   WHERE u.tipo_u=2");
    }
    if($tipo == 'empresa'){
        $sql_puntos_vecinos = mysqli_query($conexion, "SELECT DISTINCT u.id_usuario, u.nombre_u, r.descripcion_reporte, c.descripcion_colaboracion, h.puntos_h FROM usuarios u LEFT JOIN historial_puntos h 
                                                   ON u.id_usuario=h.id_usuario_h
                                                   LEFT JOIN colaboraciones_empresas c ON u.id_usuario=c.id_empresa_usuario
                                                   LEFT JOIN reportes r ON c.id_reporte_c=r.id_reporte
                                                   WHERE u.id_usuario='$ID' AND r.valido='si'");
    }

    $resultado = mysqli_num_rows($sql_puntos_vecinos);

    $total = 0;

    if($resultado > 0){ ?>

        <div class="table-responsive mt-2 bg-white p-2 border border-primary border-3">
            <table id="tabla" class="table table-striped table-hover table-dark">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Motivo</th>
                    <th>Puntos</th>
                    <th>Premios</th>
                </thead>
                <tbody>
                    <?php while($datos = mysqli_fetch_array($sql_puntos_vecinos)){ ?>
                            <tr>
                                <td><?php echo $datos['id_usuario']; ?></td>
                                <td><?php echo $datos['nombre_u']; ?></td>
                                <td><?php echo $datos['descripcion_reporte']; ?></td>
                                <td><?php echo $datos['descripcion_colaboracion']; ?></td>
                                <td><?php echo $datos['puntos_h']; ?></td>
                                <?php $total = $total + $datos['puntos_h']; ?>
                                <?php if($total == 100){ ?>
                                    <td>Insignia <img src="../imagenes/plata.png" alt="" width="50px;" height="50px;"></td>
                                <?php } else if($total == 500){ ?>
                                    <td>Insignia <img src="../imagenes/dorada.png" alt="" width="50px;" height="50px;"></td>
                                <?php } else if ($total == 1000){ ?>
                                    <td>Insignia <img src="../imagenes/diamante.png" alt="" width="50px;" height="50px;"></td>
                                <?php } ?>
                                <td><?php echo $total; ?> Puntos actuales!</td>
                                
                            </tr>
                    <?php } ?>
    <?php } else { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay puntaje de empresas que mostrar!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
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
    <title>Listar puntos de vecinos</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>