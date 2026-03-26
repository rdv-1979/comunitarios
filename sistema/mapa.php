<?php
    include './menu.php';
    include '../bd/conectar.php';

    $correo = $_SESSION['User'];
    $nombre = $_SESSION['nombre'];
    $tipo = $_SESSION['tipo'];

    $sql_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email_u='$correo'");
    $datos_usuario = mysqli_fetch_array($sql_usuario);
    $id_usuario = $datos_usuario['id_usuario'];

    $sql_categoria = mysqli_query($conexion, "SELECT * FROM categoria");

    $sql_reporte_estado = mysqli_query($conexion, "SELECT * FROM reporte_estado");
    $datos_reporte = mysqli_fetch_array($sql_reporte_estado);
    $estado = $datos_reporte['descripcion_estado'];

    $sql_reporte_estado2 = mysqli_query($conexion, "SELECT * FROM reporte_estado");

    $sql_traer_reportes = mysqli_query($conexion, "SELECT * FROM reportes r INNER JOIN usuarios u ON r.id_usuario_r=u.id_usuario
                                                   INNER JOIN categoria c ON r.id_categoria_r=c.id_categoria");   

    if(isset($_POST['guardar'])){
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
        $fecha = $_POST['fecha'];
        $estado = $_POST['estado'];
        $imagen = $_FILES['imagen']['name'];

        $captura = $_POST['capturamapa'];
      
        $captura = str_replace('data:image/png;base64,', '', $captura);
        $captura = str_replace(' ', '+', $captura);

        $captura = base64_decode($captura);

        $nombreImagen = 'captura'.time().'.png';
        $rutacaptura = './mapa/'.$nombreImagen;
        file_put_contents($rutacaptura, $captura);
        
        if($imagen == ''){
            $ruta = './vacio/vacio.png';
        }else{
            $tiempo = time();
            $copia_imagen = $_FILES['imagen']['tmp_name'];
            $ruta = './upload/'.$tiempo.$_FILES['imagen']['name'];
            move_uploaded_file($copia_imagen, $ruta);
        }
        
        $sql_generar_reporte = mysqli_query($conexion, "INSERT INTO reportes(id_usuario_r, id_categoria_r, descripcion_reporte, latitud, longitud, fecha, estado_reporte, foto, captura)
                                            VALUES ('$id_usuario', '$categoria', '$descripcion', '$latitud', '$longitud', '$fecha', '$estado', '$ruta', '$rutacaptura')");

        $sql_buscar_ultimo_reporte = mysqli_query($conexion, "SELECT * FROM reportes ORDER BY id_reporte DESC LIMIT 1");

        while($datos_ultimo = mysqli_fetch_array($sql_buscar_ultimo_reporte)){
            $id_reporte = $datos_ultimo['id_reporte'];
            $descripcion = $datos_ultimo['descripcion_reporte'];
        }

        $sql_cargar_puntos = mysqli_query($conexion, "INSERT INTO historial_puntos(id_usuario_h, id_reporte_h, puntos_h, motivo, fecha_h)
                                                      VALUES ('$id_usuario', '$id_reporte', 10, '$descripcion', NOW())");

        if($sql_generar_reporte){ ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> El reporte se generó con éxito!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = window.location.href; 
                }, 2000);
            </script>
        <?php }else{ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> No se pudo generar el reporte!.
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
    <title>Mapa de la ciudad</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <!-- Make sure you put this AFTER Leaflet's CSS -->
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <script src="https://unpkg.com/leaflet-image/leaflet-image.js"></script>
     <style>
        #map { height: 100vh; }
        .area {
            resize: none; 
        }
     </style>
</head>
<body>
    <div id="map"></div>

    <!-- Modal -->
    <?php if($tipo == 'vecino'){ ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Reportes comunitarios</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <h2>Reporte </h2>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                            <option value="">Elegir una categoría</option>
                            <?php while($datos = mysqli_fetch_array($sql_categoria)){ ?>
                                    <option value="<?php echo $datos['id_categoria']; ?>">
                                        <?php echo $datos['id_categoria']; ?> |
                                        <?php echo $datos['descripcion_categoria']; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"
                                  placeholder="Escribir aquí..." class="form-control area"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="latitud" class="form-label">Latitud</label>
                        <input type="text" name="latitud" id="latitud" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="longitud" class="form-label">Longitud</label>
                        <input type="text" name="longitud" id="longitud" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" name="fecha" id="fecha" class="form-control"
                               value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado del reporte</label>
                        <input type="text" name="estado" id="estado" class="form-control" 
                               value="<?php echo $estado; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Iamgen</label>
                        <input type="file" name="imagen" id="imagen" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="vista" class="form-label">Foto</label>
                        <img src="" id="vista" class="form-control" alt="capturamapa">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="capturamapa" id="capturamapa">
                    </div>
                    <div class="mb-3 d-grid gap-3">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" value="Guardar" name="guardar" class="btn btn-primary">
                    </div>
                </form>
            </div>            
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($tipo != 'vecino'){ ?>

    <?php } ?>
    <script>

        if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                const latitud = pos.coords.latitude;
                const longitud = pos.coords.longitude;
                let ponerIcono;

                var map = L.map('map').setView([latitud, longitud], 15);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                let marcador;

                var iconoBache = L.icon({
                    iconUrl: '../iconos/bache.png',

                    iconSize:     [32, 32], // size of the icon
                    iconAnchor:   [18, 18], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -40] // point from which the popup should open relative to the iconAnchor
                });

                var iconoBasura = L.icon({
                    iconUrl: '../iconos/basura.png',

                    iconSize:     [32, 32], // size of the icon
                    iconAnchor:   [18, 18], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -40] // point from which the popup should open relative to the iconAnchor
                });

                var iconoLuminaria = L.icon({
                    iconUrl: '../iconos/luminaria.png',

                    iconSize:     [32, 32], // size of the icon
                    iconAnchor:   [18, 18], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -40] // point from which the popup should open relative to the iconAnchor
                });

                var iconoMascota = L.icon({
                    iconUrl: '../iconos/mascota.png',

                    iconSize:     [32, 32], // size of the icon
                    iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -40] // point from which the popup should open relative to the iconAnchor
                });

                <?php while($datos_iconos = mysqli_fetch_array($sql_traer_reportes)){ ?>
                        <?php if($datos_iconos['estado_reporte'] == 'resuelto'){ ?>

                        <?php } else { ?>
                        
                        <?php if($datos_iconos['id_categoria_r'] == 5){ ?>
                                ponerIcono = iconoBasura;
                                ponerColor = 'orange';
                        <?php } ?>
                        <?php if($datos_iconos['id_categoria_r'] == 3){ ?>
                                ponerIcono = iconoMascota;
                                ponerColor = 'green';
                        <?php } ?>
                        <?php if($datos_iconos['id_categoria_r'] == 2){ ?>
                                ponerIcono = iconoLuminaria;
                                ponerColor = 'yellow';
                        <?php } ?>
                        <?php if($datos_iconos['id_categoria_r'] == 1){ ?>
                                ponerIcono = iconoBache;
                                ponerColor = 'gray';
                        <?php } ?>
                        
                        var marker = L.marker([<?php echo $datos_iconos['latitud']; ?>, <?php echo $datos_iconos['longitud']; ?>], {icon: ponerIcono}).addTo(map);
                        var circle = L.circle([<?php echo $datos_iconos['latitud']; ?>, <?php echo $datos_iconos['longitud']; ?>], {color: ponerColor, fillColor: 'blue',  fillOpacity: 0.2, radius: 90}).addTo(map);

                        <?php if($tipo == 'municipio'){ ?>
                        marker.bindPopup("<h4>Situación actual del reporte</h4><br><form action='modificar_reporte.php' method='post'>"+
                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>ID</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['id_reporte']; ?>' name='id' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Nombre</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['nombre_u']; ?>' name='nombre' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Categoría</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['descripcion_categoria']; ?>' name='descripcion' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Latitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['latitud']; ?>' name='latitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Longitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['longitud']; ?>' name='longitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Fecha</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['fecha']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Estado</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['estado_reporte']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Foto</label>"+
                                                "<img src='<?php echo $datos_iconos['foto']; ?>' alt='' name='foto' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3 d-grid gap-2'>"+
                                                "<a href='./mapa.php' class='btn btn-primary text-light form-control'>Salir</a>"+
                                                "</div>"+
                                                "</form>.");
                        <?php } ?>
                        <?php if($tipo == 'empresa'){ ?>
                        marker.bindPopup("<h4>Situación actual del reporte</h4><br><form action='modificar_reporte.php' method='post'>"+
                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>ID</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['id_reporte']; ?>' name='id' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Nombre</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['nombre_u']; ?>' name='nombre' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Categoría</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['descripcion_categoria']; ?>' name='descripcion' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Latitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['latitud']; ?>' name='latitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Longitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['longitud']; ?>' name='longitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Fecha</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['fecha']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Estado</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['estado_reporte']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Foto</label>"+
                                                "<img src='<?php echo $datos_iconos['foto']; ?>' alt='' name='foto' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3 d-grid gap-2'>"+
                                                "<a href='./mapa.php' class='btn btn-primary text-light form-control'>Salir</a>"+
                                                "</div>"+
                                                "</form>.");
                        <?php } ?>
                        <?php if($tipo == 'vecino'){ ?>
                        marker.bindPopup("<h4>Situación actual del reporte</h4><br><form action='modificar_reporte.php' method='post'>"+
                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>ID</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['id_reporte']; ?>' name='id' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Nombre</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['nombre_u']; ?>' name='nombre' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Categoría</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['descripcion_categoria']; ?>' name='descripcion' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Latitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['latitud']; ?>' name='latitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Longitud</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['longitud']; ?>' name='longitud' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Fecha</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['fecha']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Estado</label>"+
                                                "<input type='text' value='<?php echo $datos_iconos['estado_reporte']; ?>' name='fecha' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3'>"+
                                                "<label class='form-label'>Foto</label>"+
                                                "<img src='<?php echo $datos_iconos['foto']; ?>' alt='' name='foto' class='form-control' readonly>"+
                                                "</div>"+

                                                "<div class='mb-3 d-grid gap-2'>"+
                                                "<a href='./mapa.php' class='btn btn-primary text-light form-control'>Salir</a>"+
                                                "</div>"+
                                                "</form>.");
                        <?php } ?>
                <?php } ?>
                <?php } ?>

                function onMapClick(e) {
                    document.getElementById('latitud').value = e.latlng.lat;
                    document.getElementById('longitud').value = e.latlng.lng;

                    if (marcador) map.removeLayer(marcador);

                    marcador = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);

                    map.setView([e.latlng.lat, e.latlng.lng], 18);

                    // Esperar que el mapa termine de cargar
                    setTimeout(() => {
                        leafletImage(map, function (err, canvas) {

                            const imgData = canvas.toDataURL('image/png');

                            // Preview
                            document.getElementById('vista').src = imgData;

                            // Guardar base64 para enviar
                            document.getElementById('capturamapa').value = imgData;
                        });
                    }, 1000);

                    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    myModal.show();
                }

                map.on('click', onMapClick);
        
            });
           
        }
    </script>
</body>
</html>