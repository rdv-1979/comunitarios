<?php
    include '../bd/conectar.php';
    session_start();

    $correo = $_SESSION['User'];
    $nombre = $_SESSION['nombre'];
    $tipo = $_SESSION['tipo'];

    if(!isset($correo)){
        session_destroy();
        header('Location:../login.php');
        exit();
    }

    if(isset($_GET['valor'])){
        session_unset();
        session_destroy();
        header('Location:../login.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - comunitarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>
</head>
<body>
    <?php if($tipo == 'municipio'){ ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/estado.png" alt=""> Estado
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./agregar_estado.php">
                        <img src="../imagenes/agregar_estado.png" alt=""> Agregar estado</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./listar_estados.php">
                        <img src="../imagenes/lista_estado.png" alt=""> Listar estados</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/usuario.png" alt=""> Usuario
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_usuarios.php">
                        <img src="../imagenes/listar_usuarios.png" alt=""> Listar usuarios</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mapa.php">
                    <img src="../imagenes/mundo.png" alt=""> Mapa</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/tipos_usuarios.png" alt=""> Tipo Usuario
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./agregar_tipo_usuario.php">
                        <img src="../imagenes/agregar_tipo_usuario.png" alt=""> Agregar tipo usuario</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./listar_tipo_usuario.php">
                        <img src="../imagenes/listar_tipo_usuario.png" alt=""> Listar tipo usuarios</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/categorias.png" alt=""> Categoría
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./agregar_categoria.php">
                        <img src="../imagenes/agregar_categorias.png" alt=""> Agregar categoría</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./listar_categorias.php">
                        <img src="../imagenes/listar_categorias.png" alt=""> Listar categorías</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/reportes.png" alt=""> Reportes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_reporte.php">
                        <img src="../imagenes/listar_reporte.png" alt=""> Listar reportes</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/puntos.png" alt=""> Puntos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./puntos_vecino.php">
                        <img src="../imagenes/puntos_vecino.png" alt=""> Puntos vecinos</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./puntos_empresa.php">
                        <img src="../imagenes/puntos_empresa.png" alt=""> Puntos empresas</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/mensaje.png" alt=""> Mensajes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_mensajes.php">
                        <img src="../imagenes/lista_mensajes.png" alt=""> Lista de mensajes</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/colaboracion.png" alt=""> Colaboraciones
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./colaboraciones_empresas.php">
                        <img src="../imagenes/lista_colaboracion.png" alt=""> Listar colaboraciones</a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="menu.php?valor=<?php echo $correo; ?>"
                   onclick="return confirm('¿Desea salir del sistema?');">
                   <img src="../imagenes/apagar.png" alt=""> Salir</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <?php } ?>
    <?php if($tipo == 'empresa'){ ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/empresa.png" alt=""> Empresas
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_empresas.php">
                        <img src="../imagenes/listar_empresas.png" alt=""> Colaborar</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/puntos.png" alt=""> Puntos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./puntos_empresa.php">
                        <img src="../imagenes/puntos_empresa.png" alt=""> Puntos empresas</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/reportes.png" alt=""> Reportes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_reporte.php">
                        <img src="../imagenes/listar_reporte.png" alt=""> Listar reportes</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/mensaje.png" alt=""> Mensajes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_mensajes.php">
                        <img src="../imagenes/lista_mensajes.png" alt=""> Listar mensajes</a></li>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item" href="./agregar_mensaje.php">
                        <img src="../imagenes/enviar_mensaje.png" alt=""> Enviar mensaje</a></li>
                </ul>
            </li>      
            <li class="nav-item">
                <a class="nav-link" href="menu.php?valor=<?php echo $correo; ?>"
                   onclick="return confirm('¿Desea salir del sistema?');">
                   <img src="../imagenes/apagar.png" alt=""> Salir</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <?php } ?>
    <?php if($tipo == 'vecino'){ ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/reportes.png" alt=""> Reportes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_reporte.php">
                        <img src="../imagenes/listar_reporte.png" alt=""> Listar reportes</a></li>
                </ul>
            </li>
             <li class="nav-item">
                    <a class="nav-link" href="mapa.php">
                    <img src="../imagenes/mundo.png" alt=""> Mapa</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/puntos.png" alt=""> Puntos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./puntos_vecino.php">
                        <img src="../imagenes/puntos_vecino.png" alt=""> Puntos vecinos</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../imagenes/mensaje.png" alt=""> Mensajes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar_mensajes.php">
                        <img src="../imagenes/lista_mensajes.png" alt=""> Listar mensajes</a></li>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item" href="./agregar_mensaje.php">
                        <img src="../imagenes/enviar_mensaje.png" alt=""> Enviar mensaje</a></li>
                </ul>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="menu.php?valor=<?php echo $correo; ?>"
                   onclick="return confirm('¿Desea salir del sistema?');">
                   <img src="../imagenes/apagar.png" alt=""> Salir</a>
            </li>
            </ul>
            </div>
        </div>    
        </nav>
    <?php } ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>