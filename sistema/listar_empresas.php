<?php
    include './menu.php';
    include '../bd/conectar.php';

    $ID = $_SESSION['IDusuario'];

    $sql_usuarios = mysqli_query($conexion, "SELECT *, SUM(h.puntos_h) as puntos FROM usuarios u INNER JOIN tipo_usuarios t ON
                                            u.tipo_u=t.id_tipo_usuario
                                            INNER JOIN historial_puntos h ON u.id_usuario=h.id_usuario_h
                                            WHERE u.tipo_u=2 AND u.id_usuario='$ID'");

    $resultado = mysqli_num_rows($sql_usuarios);

    if($resultado <= 0){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay usuarios para mostrar!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }else{ ?>
        <div class="table-responsive mt-3 bg-white p-2 border border-primary border-3">
            <table id="tabla" class="table table-striped table-hover table-dark">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php while($datos = mysqli_fetch_array($sql_usuarios)){ ?>
                            <tr>
                                <td><?php echo $datos['id_usuario']; ?></td>
                                <td><?php echo $datos['nombre_u']; ?></td>
                                <td><?php echo $datos['email_u']; ?></td>
                                <td><?php echo $datos['descripcion_tipo_usuario']; ?></td>
                                <td>
                                    <a href="colaboraciones_reportes.php?id=<?php echo $datos['id_usuario']; ?>"" class="btn btn-warning">Colaboraciones</a>
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
    <title>Listar empresas</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>