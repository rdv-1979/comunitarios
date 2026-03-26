<?php
    session_start();
    include './bd/conectar.php';

    if(isset($_POST['login'])){
        $correo = $_POST['usuario'];
        $clave = $_POST['clave'];

        $sql_login = mysqli_query($conexion, "SELECT * FROM usuarios u INNER JOIN tipo_usuarios t ON
                                              u.tipo_u=t.id_tipo_usuario
                                              WHERE u.email_u='$correo' AND u.clave='$clave' AND u.valor_estado!='suspendido'");
        $resultado = mysqli_num_rows($sql_login);

        if($resultado > 0){
            while($datos = mysqli_fetch_array($sql_login)){
                $nombre = $datos['nombre_u'];
                $tipo = $datos['descripcion_tipo_usuario'];
                $correo = $datos['email_u'];
                $id_usuario = $datos['id_usuario'];
            }
            $_SESSION['User'] = $correo;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['tipo'] = $tipo;
            $_SESSION['IDusuario'] = $id_usuario;
            header('Location:./sistema/menu.php');

        }else{ ?>            
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cuidado!</strong> El usuario y/o clave son incorrectos o usted fue temporalmente suspendido!.
                                          Ante la duda, por favor cumuniquese con el municipio!.
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
    <title>Reportes comunitarios - Login</title>
    <link rel="shortcut icon" href="./imagenes/palacio.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-image: url('./imagenes/fondo.jpg');
             background-position: center;
             background-size: cover;
             background-repeat:no-repeat;
             height: 100%;">
    <div class="container-md col-md-6 mt-3">
        <form action="" method="post" class="bg-white p-2 border border-primary border-3">
            <div class="mb-3">
                <h2>Reportes comunitarios - Login</h2>
                <label for="usuario" class="form-label" name="usuario" id="usuario">Email</label>
                <input type="email" class="form-control" name="usuario" id="usuario" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Nunca compartas tu correo con alguien.</div>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
            </div>
            <div class="mb-3 d-grid gap-3">
                <input type="submit" value="Login" name="login" class="form-control btn btn-primary">
                <a href="registro.php" class="form-control btn btn-success">Sin cuenta? | Registrar!</a>
                <a href="index.html" class="form-control btn btn-warning">Salir!</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>