<?php
    include './menu.php';
    include '../bd/conectar.php';

    $ID = $_SESSION['IDusuario'];
    $tipo = $_SESSION['tipo'];

    if($tipo == 'municipio'){
        $sql_usuarios = mysqli_query($conexion, "SELECT * FROM usuarios u INNER JOIN mensajes m ON u.id_usuario=m.usuario_m
                                                 WHERE u.valor_estado!='suspendido'");
    }
    if($tipo == 'empresa'){
        $sql_usuarios = mysqli_query($conexion, "SELECT * FROM usuarios u INNER JOIN mensajes m ON u.id_usuario=m.usuario_m 
                                                 WHERE u.id_usuario='$ID'");
    }
    if($tipo == 'vecino'){
        $sql_usuarios = mysqli_query($conexion, "SELECT * FROM usuarios u INNER JOIN mensajes m ON u.id_usuario=m.usuario_m 
                                                 WHERE u.id_usuario='$ID'");
    }
    
    $resultado = mysqli_num_rows($sql_usuarios);

    if($resultado <= 0){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay mensajes para mostrar o este usuario fue temporalmente suspendido!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }else{ ?>
        <div class="table-responsive mt-3 bg-white p-2 border border-primary border-3">
            <table id="tabla" class="table table-striped table-hover table-dark">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Mensaje</th>
                    <th>Respuesta</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php while($datos = mysqli_fetch_array($sql_usuarios)){ ?>
                            <tr>
                                <td><?php echo $datos['id_usuario']; ?></td>
                                <td><?php echo $datos['nombre_u']; ?></td>
                                <td><?php echo $datos['fecha']; ?></td>
                                <td><?php echo $datos['mensaje']; ?></td>
                               
                                    <?php if($tipo != 'municipio' && $datos['respuesta'] == ''){ ?>
                                        <td><span class="badge text-bg-primary" style="font-size:18px;">Sin respuesta ❌</span></td>
                                    <?php } else { ?>
                                        <td><?php echo $datos['respuesta']; ?></td>
                                    <?php } ?>
    
                                    <?php if($tipo == 'municipio' && $datos['respuesta'] == ''){ ?>
                                        <td><a href="./responder_mensaje.php?id=<?php echo $datos['id_mensaje']; ?>" class="btn btn-danger">Responder</a></td>
                                    <?php } else if($tipo == 'municipio' && $datos['respuesta'] != ''){ ?>
                                        <td><span class="badge text-bg-primary" style="font-size:18px;"> ✔</span></td>
                                    <?php } else if($tipo != 'municipio' && $datos['respuesta'] != ''){ ?>
                                        <td><span class="badge text-bg-primary" style="font-size:18px;"> ✔</span></td>
                                    <?php } else if($tipo != 'municipio' && $datos['respuesta'] == ''){ ?>
                                        <td><span class="badge text-bg-primary" style="font-size:18px;"> ⌛</span></td>
                                    <?php } ?>
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
    <title>Listar mensajes</title>
</head>
<body>
    <script>
        let table = new DataTable('#tabla');
    </script>
</body>
</html>