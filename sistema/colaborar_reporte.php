<?php
    include '../bd/conectar.php';
    include './menu.php';

    if(isset($_REQUEST['id_u']) && isset($_REQUEST['id_r'])){
        $id_u = $_REQUEST['id_u'];
        $id_r = $_REQUEST['id_r'];

        $sql_reporte = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                    INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria
                                                    WHERE r.id_reporte='$id_r'");

        while($datos = mysqli_fetch_array($sql_reporte)){
            $id_reporte =  $datos['id_reporte']; 
            $nombre_u =  $datos['nombre_u']; 
            $email_u = $datos['email_u']; 
            $categoria =  $datos['descripcion_categoria']; 
            $descripcion =  $datos['descripcion_reporte']; 
            $latitud =  $datos['latitud']; 
            $longitud =  $datos['longitud']; 
            $fecha =  $datos['fecha']; 
            $estado =  $datos['estado_reporte'];
            $imagen = $datos['foto'];
        }
        
    }

    if(isset($_POST['colaborar'])){
        $id_u = $_REQUEST['id_u'];
        $id_r = $_REQUEST['id_r'];
        $colaboracion = $_POST['colaboracion'];

        $sql_colaboracion = mysqli_query($conexion, "INSERT INTO colaboraciones_empresas (id_empresa_usuario, id_reporte_c, descripcion_colaboracion)
                                                     VALUES ('$id_u', '$id_r', '$colaboracion')");
        
        $sql_historial_puntos = mysqli_query($conexion, "INSERT INTO historial_puntos(id_usuario_h, id_reporte_h, puntos_h)
                                                         VALUES ('$id_u', '$id_r', 10)");

        if($sql_colaboracion){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> La colaboración fue carga de forma exitosa!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = './colaboraciones_reportes.php'; 
                }, 2000);
            </script>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> No se pudo realizar la colaboración!.
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
    <title>Colaboración al proyecto</title>
</head>
<body>
    <div class="container-md col-md-6">
        <form action="" method="post" class="bg-white p-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Reporte a colaborar</h2>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" 
                       value="<?php echo $descripcion; ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" name="categoria" id="categoria" 
                       value="<?php echo $categoria; ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="nom_u" class="form-label">Nombre usuario</label>
                <input type="text" name="nom_u" id="nom_u" 
                       value="<?php echo $nombre_u; ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="text" name="fecha" id="fecha" 
                       value="<?php echo $fecha; ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado actual</label>
                <input type="text" name="estado" id="estado" 
                       value="<?php echo $estado; ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Foto</label>
                <img src="<?php echo $imagen; ?>" alt="imagen" class="form-control">
            </div>
            <div class="mb-3">
                <label for="colaboracion" class="form-label">Colaboración</label>
                <textarea name="colaboracion" id="colaboracion" cols="30" rows="10" class="form-control" 
                          style="resize:none;" placeholder="Escribir aquí..." required></textarea>
            </div>
            <div class="mb-3 d-grid gap-2">
                <input type="submit" value="Colaborar" name="colaborar" class="form-control btn btn-success"
                       onclick="return confirm('¿Desea colaborar con este reporte?');">
                       <a href="colaboraciones_reportes.php" class="form-control btn btn-info">Salir</a>
            </div>
        </form>
    </div>
</body>
</html>