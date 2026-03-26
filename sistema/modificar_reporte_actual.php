<?php
    include '../bd/conectar.php';
    include './menu.php';

    $sql_estados_reporte = mysqli_query($conexion, "SELECT * FROM reporte_estado");

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_modificar_reporte = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                    INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria
                                                    INNER JOIN historial_puntos h ON r.id_reporte=h.id_reporte_h
                                                    WHERE r.id_reporte='$id'");

        while($datos = mysqli_fetch_array($sql_modificar_reporte)){
                $id_reporte = $datos['id_reporte'];
                $nombre = $datos['nombre_u'];
                $correo = $datos['email_u'];
                $descripcion = $datos['descripcion_reporte'];
                $latitud = $datos['latitud'];
                $longitud = $datos['longitud'];
                $fecha = $datos['fecha'];
                $estado = $datos['estado_reporte'];
                $imagen = $datos['foto'];
        }

    }

    if(isset($_POST['modificar'])){
        $id = $_REQUEST['id'];
        $estado = $_POST['estado'];
        $observacion = $_POST['observacion'];
        $valido = $_POST['valido'];

        if($estado == 1){
            $estado = 'pendiente';
        }
        if($estado == 2){
            $estado = 'en_proceso';
        }
        if($estado == 5){
            $estado = 'resuelto';
        }

        $sql_mod_estado = mysqli_query($conexion, "UPDATE reportes SET estado_reporte='$estado',
                                                                       observacion_r='$observacion',
                                                                       valido='$valido'
                                                   WHERE id_reporte='$id'");

        if($sql_mod_estado){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El reporte se modificó con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Error al modificar el reporte!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar reporte</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Modificar reporte</h2>
            </div>
            <div class="mb-3">
                <label for="id" class="form-label">#</label>
                <input type="text" name="id" id="id" class="form-control"
                       value="<?php echo $id_reporte; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                       value="<?php echo $nombre; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="text" name="correo" id="correo" class="form-control"
                       value="<?php echo $correo; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                       value="<?php echo $descripcion; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="latitud" class="form-label">Latitud</label>
                <input type="text" name="latitud" id="latitud" class="form-control"
                       value="<?php echo $latitud; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="longitud" class="form-label">Longitud</label>
                <input type="text" name="longitud" id="longitud" class="form-control"
                       value="<?php echo $longitud; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="text" name="fecha" id="fecha" class="form-control"
                       value="<?php echo $fecha; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <input type="text" class="form-control" value="<?php echo $estado; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Cambiar estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Elegir estado</option>
                    <?php while($datos_estado = mysqli_fetch_array($sql_estados_reporte)){ ?>
                            <option value="<?php echo $datos_estado['id_estado_reporte']; ?>">
                                <?php echo $datos_estado['id_estado_reporte']; ?> |
                                <?php echo $datos_estado['descripcion_estado']; ?>
                            </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <img src="<?php echo $imagen; ?>" alt="imagen" class="form-control">
            </div>
            <div class="mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea name="observacion" id="observacion" cols="30" rows="10" 
                          class="form-control" placeholder="Escribir aquí..." 
                          style="resize: none;"required></textarea>
            </div>
            <div class="mb-3">
                <label for="valido" class="form-label">Valido</label>
                <select name="valido" id="valido" class="form-control">
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Modificar" name="modificar" class="form-control btn btn-primary">
                <a href="listar_reporte.php" class="form-control btn btn-info">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>