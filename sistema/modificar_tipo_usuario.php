<?php
    include './menu.php';
    include '../bd/conectar.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM tipo_usuarios WHERE id_tipo_usuario='$id'");

        $datos = mysqli_fetch_array($sql_buscar);

        $descripcion = $datos['descripcion_tipo_usuario'];

    }

    if(isset($_POST['modificar'])){
        $id = $_REQUEST['id'];
        $descripcion = $_POST['descripcion'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM tipo_usuarios WHERE descripcion_tipo_usuario='$descripcion'");

        $resultado = mysqli_num_rows($sql_buscar);

        if($resultado > 0){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> El tipo de usuario se ya existe!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } else {
            $sql_modificar = mysqli_query($conexion, "UPDATE tipo_usuarios SET descripcion_tipo_usuario='$descripcion'
                                                 WHERE id_tipo_usuario='$id'");

            if($sql_modificar){ ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Correcto!</strong> El estado se modificó con éxito!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }else{ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Error al modificar el estado!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar tipo de usuario</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Modificar tipo de usuario</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                       value="<?php echo $descripcion; ?>" required>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Modificar" name="modificar" class="form-control btn btn-danger"
                       onclick="return confirm('¿Desea modificar el tipo de usuario seleccionado?');">
                <a href="listar_tipo_usuario.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>