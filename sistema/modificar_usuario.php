<?php
    include '../bd/conectar.php';
    include './menu.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM usuarios u INNER JOIN tipo_usuarios t ON
                                                u.tipo_u=t.id_tipo_usuario WHERE u.id_usuario='$id'");
        while($datos = mysqli_fetch_array($sql_buscar)){
            $nombre = $datos['nombre_u'];
            $correo = $datos['email_u'];
            if($datos['descripcion_tipo_usuario'] == 'empresa'){
                $tipo = $datos['descripcion_tipo_usuario'];
                $cuil = $datos['cuil'];
                $maravilla = $datos['maravilla'];
            }else{
                $tipo = $datos['descripcion_tipo_usuario'];
            }
        }
                                
    }

    if(isset($_POST['modificar'])){
        $id = $_REQUEST['id'];
        $nombre = $_POST['nombre'];
        $observacion = $_POST['observacion'];
        $valor_estado = $_POST['valor_plataforma'];

       
        $sql_modificar = mysqli_query($conexion, "UPDATE usuarios SET nombre_u='$nombre',
                                                                        observacion='$observacion',
                                                                        valor_estado='$valor_estado'
                                                                        WHERE id_usuario='$id'");

        if($sql_modificar){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El usuario fue modificado correctamente!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> No se modificó el usuario!.
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
    <title>Modificar usuario</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Modificar usuario</h2>
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
                <label for="correo" class="form-label">Descripción</label>
                <input type="text" name="correo" id="correo" class="form-control" 
                       value="<?php echo $tipo; ?>" readonly>
            </div>
            <?php if($tipo == 'empresa'){ ?>
                    <div class="mb-3">
                        <label for="cuil" class="form-label">C.U.I.L</label>
                        <input type="text" name="cuil" id="cuil" class="form-control" 
                            value="<?php echo $cuil; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="maravilla" class="form-label">Nombre - empresa</label>
                        <input type="text" name="maravilla" id="maravilla" class="form-control" 
                            value="<?php echo $maravilla; ?>" readonly>
                    </div>
            <?php } ?>
            <div class="mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea name="observacion" id="observacion" cols="30" rows="10" 
                          class="form-control" style="resize: none;" placeholder="Escribir aquí..."></textarea>
            </div>
            <div class="mb-3">
                <label for="valor_plataforma" class="form-label">Estado en la plataforma</label>
                <select name="valor_plataforma" id="valor_plataforma" class="form-control">
                    <option value="activo">Activo</option>
                    <option value="suspendido">Suspendido</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Modificar" name="modificar" class="form-control btn btn-danger"
                       onclick="return confirm('¿Desea modificar este usuario?');">
                <a href="./listar_usuarios.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>