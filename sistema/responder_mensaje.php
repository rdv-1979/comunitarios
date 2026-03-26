<?php
    include '../bd/conectar.php';
    include './menu.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_buscar_mensaje_vecino = mysqli_query($conexion, "SELECT * FROM mensajes m INNER JOIN usuarios u 
                                                       ON m.usuario_m=u.id_usuario WHERE id_mensaje='$id'");

        $resultado_vecino = mysqli_fetch_array($sql_buscar_mensaje_vecino);

        if($resultado_vecino > 0){

            while($datos = mysqli_fetch_array($sql_buscar_mensaje_vecino)){
                $nombre = $datos['nombre_u'];
                $correo = $datos['email_u'];
                $tipo_u = $datos['tipo_u'];
                $fecha = $datos['fecha'];
                $mensaje = $datos['mensaje'];
            }

        }
        

        
        $sql_buscar_mensaje_empresa = mysqli_query($conexion, "SELECT * FROM mensajes m INNER JOIN usuarios u 
                                                       ON m.usuario_m=u.id_usuario WHERE id_mensaje='$id'");

        $resultado_empresa = mysqli_num_rows($sql_buscar_mensaje_empresa);

        if($resultado_empresa > 0){
            
            while($datos = mysqli_fetch_array($sql_buscar_mensaje_empresa)){
                $nombre = $datos['nombre_u'];
                $correo = $datos['email_u'];
                $tipo_u = $datos['tipo_u'];
                $fecha = $datos['fecha'];
                $mensaje = $datos['mensaje'];
                $cuil = $datos['cuil'];
                $maravilla = $datos['maravilla'];
            }
        }        

    }

    if(isset($_POST['responder'])){
        $id = $_REQUEST['id'];
        $respuesta = $_POST['respuesta'];

        $sql_repuesta = mysqli_query($conexion, "UPDATE mensajes SET respuesta='$respuesta', estado_m=1 
                                                 WHERE id_mensaje='$id'");
        if($sql_repuesta){ ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> EL mensaje se respondió con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> No se pudo responder el mensaje!.
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
    <title>Responder mensaje</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-">
                <h2>Responder mensaje</h2>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" 
                       value="<?php echo $nombre; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" name="correo" id="correo" class="form-control" 
                       value="<?php echo $correo; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="text" name="fecha" id="fecha" class="form-control" 
                    value="<?php echo $fecha; ?>" readonly>
            </div>
            <?php if($tipo_u == 2){ ?>
                <div class="mb-3">
                    <label for="cuil" class="form-label">C.U.I.L/C.U.I.T</label>
                    <input type="text" name="cuil" id="cuil" class="form-control"
                           value="<?php echo $cuil; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="maravilla" class="form-label">Nombre - maravilla</label>
                    <input type="text" name="maravilla" id="maravilla" class="form-control" style="resize: none;"
                           value="<?php echo $maravilla; ?>" readonly>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea name="mensaje" id="mensaje" cols="30" rows="10" class="form-control" style="resize: none;"
                          readonly> <?php echo $mensaje; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="respuesta" class="form-label">Respuesta</label>
                <textarea name="respuesta" id="respuesta" cols="30" rows="10" class="form-control"
                          placeholder="Escribir aquí..." required></textarea>
            </div>
            <div class="mb-3 d-grid gap-2">
                <input type="submit" value="Responder" name="responder" class="form-control btn btn-primary"
                       onclick="return confirm('¿Desea responder esta pregunta?');">
                <a href="listar_mensajes.php" class="form-control btn btn-success">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>