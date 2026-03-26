<?php
    include '../bd/conectar.php';
    include './menu.php';

    $ID = $_SESSION['IDusuario'];

    $sql_buscar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario='$ID'");

    while($datos = mysqli_fetch_array($sql_buscar_usuario)){
        $nombre = $datos['nombre_u'];
        $correo = $datos['email_u'];
    }

    if(isset($_POST['enviar'])){
        $mensaje = $_POST['mensaje'];
        $fecha = $_POST['fecha'];

        $sql_enviar_mensaje = mysqli_query($conexion, "INSERT INTO mensajes(usuario_m, mensaje) VALUES ('$ID', '$mensaje')");

        if($sql_enviar_mensaje){ ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El mensaje se envió con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Error al enviar el mensaje!.
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
    <title>Enviar Mensajes</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Enviar mensaje</h2>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" 
                       class="form-control" value="<?php echo $nombre; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="text" name="correo" id="correo" 
                       class="form-control" value="<?php echo $correo; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="text" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>"readonly>
            </div>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea name="mensaje" id="mensaje" cols="30" rows="10" placeholder="Escriba aquí..."
                          class="form-control" style="resize:none;" required></textarea>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Enviar" name="enviar" class="form-control btn btn-primary"
                       onclick="return confirm('¿Desea enviar el mensaje?');">
                <a href="listar_mensajes.php" class="form-control btn btn-success">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>