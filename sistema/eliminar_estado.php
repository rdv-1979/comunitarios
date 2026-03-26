<?php
    include './menu.php';
    include '../bd/conectar.php';

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM reporte_estado WHERE id_estado_reporte='$id'");

        $datos = mysqli_fetch_array($sql_buscar);

        $descripcion = $datos['descripcion_estado'];

    }

    if(isset($_POST['eliminar'])){
        $id = $_REQUEST['id'];

        $sql_eliminar = mysqli_query($conexion, "DELETE FROM reporte_estado WHERE id_estado_reporte='$id'");

        if($sql_eliminar){ ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El estado se borró con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Error al borrar el estado!.
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
    <title>Eliminar estado</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Eliminar estado</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                       value="<?php echo $descripcion; ?>" readonly>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Eliminar" name="eliminar" class="form-control btn btn-danger"
                       onclick="return confirm('¿Desea eliminar el estado seleccionado?');">
                <a href="listar_estados.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>