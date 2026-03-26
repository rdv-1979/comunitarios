<?php
    include './menu.php';
    include '../bd/conectar.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM categoria WHERE id_categoria='$id'");

        $datos = mysqli_fetch_array($sql_buscar);

        $descripcion = $datos['descripcion_categoria'];

    }

    if(isset($_POST['modificar'])){
        $id = $_REQUEST['id'];
        $descripcion = $_POST['descripcion'];

        $sql_buscar_categoria = mysqli_query($conexion, "SELECT * FROM categoria WHERE descripcion_categoria='$descripcion'");

        $resultado = mysqli_num_rows($sql_buscar_categoria);

        if($resultado > 0){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> La categoría ya existe!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{
                $sql_modificar = mysqli_query($conexion, "UPDATE categoria SET descripcion_categoria='$descripcion'
                                                 WHERE id_categoria='$id'");

                if($sql_modificar){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> La categoría se modificó con éxito!.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Error al modificar la categoría!.
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
    <title>Modificar categoría</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Modificar categoría</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                       value="<?php echo $descripcion; ?>" required>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Modificar" name="modificar" class="form-control btn btn-danger"
                       onclick="return confirm('¿Desea modificar la categoría seleccionada?');">
                <a href="listar_categorias.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>