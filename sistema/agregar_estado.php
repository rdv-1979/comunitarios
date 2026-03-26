<?php
    include './menu.php';
    include '../bd/conectar.php';

    if(isset($_POST['agregar'])){
        $descripcion = $_POST['descripcion'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM reporte_estado WHERE descripcion_estado='$descripcion'");

        $resultado = mysqli_num_rows($sql_buscar);

        if($resultado > 0){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> El estado ya se encuentra en el sistema!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{
                $sql_agregar_estado = mysqli_query($conexion, "INSERT INTO reporte_estado(descripcion_estado)
                                                               VALUES ('$descripcion')");
                if($sql_agregar_estado){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> El estado se guardó con éxito!.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Error al guardar el estado!.
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
    <title>Agregar estado</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Agregar estado</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>
            <div class="mb-3 d-grid gap-2">
                <input type="submit" value="Agregar" name="agregar" class="form-control btn btn-success">
                <a href="listar_estados.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>