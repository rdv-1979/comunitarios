<?php
    include '../bd/conectar.php';
    include './menu.php';

    $sql_tipo_usuario = mysqli_query($conexion, "SELECT * FROM tipo_usuarios
                                                 WHERE descripcion_tipo_usuario != 'municipio'");
    if(isset($_POST['agregar'])){
        $nombre = $_POST['nombre'];
        $correo = $_POST['usuario'];
        $clave = $_POST['clave'];
        $tipo_usuario = $_POST['tipo'];
      
        if($tipo_usuario == 2){
            $cuil = $_POST['cuil'];
            $maravilla = $_POST['maravilla'];
        }
        
        $sql_buscar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email_u='$correo'");

        $resultado = mysqli_num_rows($sql_buscar_usuario);

        if($resultado > 0){ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> El usuario y clave ingresados ya existen!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } else if($tipo_usuario == 2){
                        $sql_insertar_empresa = mysqli_query($conexion, "INSERT INTO usuarios(nombre_u, email_u, clave, tipo_u, cuil, maravilla, puntos)
                                                     VALUES ('$nombre', '$correo', '$clave', '$tipo_usuario', '$cuil', '$maravilla', 0)");
                if($sql_insertar_empresa){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> El usuario fue registrado con éxito!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> No se pudo realizar el registro de usuario!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }                        
              } else {
                $sql_insertar_usuario = mysqli_query($conexion, "INSERT INTO usuarios(nombre_u, email_u, clave, tipo_u, puntos)
                                                     VALUES ('$nombre', '$correo', '$clave', '$tipo_usuario', 0)");
                if($sql_insertar_usuario){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> El usuario fue registrado con éxito!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> No se pudo realizar el registro de usuario!
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
    <title>Agregar usuarios</title>
    <link rel="shortcut icon" href="./imagenes/palacio.png" type="image/x-icon">
</head>
<body>
    <div class="container-md col-md-6 mt-3">
        <form action="" method="post" id="formulario" class="bg-white p-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Agregar usuario</h2>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label" name="usuario" id="usuario">Email</label>
                <input type="email" class="form-control" name="usuario" id="usuario" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Nunca compartas tu correo con alguien.</div>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form label">Tipo de usuario</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="">Elegir una opción</option>
                    <?php while($datos = mysqli_fetch_array($sql_tipo_usuario)){ ?>
                            <option value="<?php echo $datos['id_tipo_usuario']; ?>">
                                <?php echo $datos['id_tipo_usuario']; ?> |
                                <?php echo $datos['descripcion_tipo_usuario']; ?>
                            </option>
                    <?php } ?>
                </select>
                <div class="mb-3" id="agregar_empresa"></div>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Agregar" name="agregar" class="form-control btn btn-primary">
                <a href="listar_usuarios.php" class="form-control btn btn-success">Salir</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $('#tipo').on('change', function(){
                var valor_tipo = $(this).val();
                if(valor_tipo == 2){
                    $('#agregar_empresa').append('<label class="form-label">Ingresar C.U.I.L</label>');
                    $('#agregar_empresa').append('<input type="number" name="cuil" class="form-control" required>');
                    $('#agregar_empresa').append('<label class="form-label">Ingresar Nombre-maravilla</label>');
                    $('#agregar_empresa').append('<input type="text" name="maravilla" class="form-control" required>');
                }
                else{
                    $('#agregar_empresa').html('');
                }
            })
        });
    </script>
</body>
</html>