<?php
    include '../bd/conectar.php';
    include './menu.php';

    if(isset($_POST['modificar'])){
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
        $fecha = $_POST['fecha'];
        $estado = $_POST['estado'];

        if($estado == 1){
            $estado = 'pendiente';
        }
        if($estado == 2){
            $estado = 'en_proceso';
        }
        if($estado == 5){
            $estado = 'resuelto';
        }

        $sql_cambiar_estado = mysqli_query($conexion, "UPDATE reportes SET estado_reporte='$estado' WHERE id_reporte='$id'");

        if($sql_cambiar_estado){ ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El estado del reporte se modificá con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = './mapa.php'; 
                }, 2000);
            </script>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Falló la modificación del estado del reporte!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }
    }
?>
