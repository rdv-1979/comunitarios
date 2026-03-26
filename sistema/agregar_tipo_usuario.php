<?php
    include './menu.php';
    include '../bd/conectar.php';

    if(isset($_POST['agregar'])){
        $descripcion = $_POST['descripcion'];

        $sql_buscar = mysqli_query($conexion, "SELECT * FROM tipo_usuarios WHERE descripcion_tipo_usuario='$descripcion'");

        $resultado = mysqli_num_rows($sql_buscar);

        if($resultado > 0){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> El tipo de usuario ya se encuentra en el sistema!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }else{
                $sql_agregar_tipo_usuario = mysqli_query($conexion, "INSERT INTO tipo_usuarios(descripcion_tipo_usuario)
                                                               VALUES ('$descripcion')");
                if($sql_agregar_tipo_usuario){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> El tipo usuario se guardó con éxito!.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Error al guardar el tipo usuario!.
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
    <title>Agregar tipo usuario</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 mt-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Agregar tipo usuario</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>
            <div class="mb-3 d-grid gap-2">
                <input type="submit" value="Agregar" name="agregar" class="form-control btn btn-success">
                <a href="listar_tipo_usuario.php" class="form-control btn btn-primary">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>