<?php
    include '../bd/conectar.php';
    include './menu.php';

    $tipo = $_SESSION['tipo'];
    $ID = $_SESSION['IDusuario'];

    if($tipo == 'vecino'){
        $sql_listar_reportes = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                    INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria
                                                    WHERE u.id_usuario='$ID'");
    }
    if($tipo == 'empresa'){
        $sql_listar_reportes = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                    INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria");
    }
    if($tipo == 'municipio'){
        $sql_listar_reportes = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                    INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria");
    }

    $resultado = mysqli_num_rows($sql_listar_reportes);

    if($resultado <= 0){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Advertencia!</strong> No hay reportes para mostrar.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }else{ ?>
            <div class="table-responsive bg-white mt-2 p-2 border border-primary border-3">
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
                        <th>Captura</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Imagen</th>
                        <th>Observación</th>
                        <th>Valido</th>
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
                                <td><img src="<?php echo $datos['captura']; ?>" onclick="mostrar(this.src);" alt="captura" width="100px;" height="100px;"></td>
                                <td><?php echo $datos['fecha']; ?></td>
                                <td><?php echo $datos['estado_reporte']; ?></td>
                                <td><img src="<?php echo $datos['foto']; ?>" alt="imagen" width="50px" height="50px;"></td>
                                <td><?php echo $datos['observacion_r']; ?></td>
                                <td><?php echo $datos['valido']; ?></td>
                                <td>
                                    <?php if($datos['estado_reporte'] == 'resuelto' && $tipo == 'municipio'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;">Resuelto ✔</span>
                                    <?php } else if($datos['estado_reporte'] != 'resuelto' && $tipo == 'municipio'){ ?>
                                            <a href="modificar_reporte_actual.php?id=<?php echo $datos['id_reporte']; ?>" class="btn btn-primary">Modificar</a>
                                    <?php } else if($datos['estado_reporte'] == 'pendiente' && $tipo == 'empresa'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> ⏲</span>
                                    <?php } else if($datos['estado_reporte'] == 'en_proceso' && $tipo == 'empresa'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> 🦾</span>
                                    <?php } else if($datos['estado_reporte'] == 'resuelto' && $tipo == 'empresa'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> ✔</span>
                                    <?php } else if($datos['estado_reporte'] == 'pendiente' && $tipo == 'vecino'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> ⏲</span>
                                    <?php } else if($datos['estado_reporte'] == 'en_proceso' && $tipo == 'vecino'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> 🦾</span>
                                    <?php } else if($datos['estado_reporte'] == 'resuelto' && $tipo == 'vecino'){ ?>
                                            <span class="badge text-bg-primary" style="font-size:18px;"><?php $datos['estado_reporte']; ?> ✔</span>
                                    <?php } ?>
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
    <title>Listar reportes</title>
</head>
<body>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Mapa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" id="vista" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script>
        let table = new DataTable('#tabla');
        function mostrar(valor){
            document.getElementById('vista').src = valor;
            const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    </script>
</body>
</html>