<?php
     require('../fpdf/fpdf.php');

    $pdf = new FPDF('L','mm','Legal');
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',16);
    $pdf->Image('../imagenes/logo.png',10,12,30,0,'');
    $fecha = date(':i:s');

    $fecha_actual = "Hoy ".date('d')." de ".date('m').utf8_decode(" del año ").date('Y');
    $hora_actual = date('H');
  
    $pdf->Cell(100,20);
    $pdf->Cell(130,20,$fecha_actual.' '.$hora_actual.''.$fecha,0,1,'C');

    $pdf->SetFont('Arial','I',16);

    $pdf->Cell(55,10);
    $pdf->Cell(100,10,utf8_decode('Informe: Situación de mascotas!"'),1,1,'C');

    $pdf->Cell(55,10,"",0,1);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(0,80,180);
    $pdf->SetFillColor(250,34,102);
    $pdf->SetTextColor(45,23,89);
    $pdf->Cell(10,10,"#",1,0,'C',True);
    $pdf->Cell(40,10,utf8_decode("Maravilla"),1,0,'C',True);
    $pdf->Cell(40,10,utf8_decode("Nombre"),1,0,'C',True);
    $pdf->Cell(40,10,"Correo",1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("Descripción"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("F. reporte"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("Estado"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("Captura"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("Observación"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("D. colaboración"),1,0,'C',True);
    $pdf->Cell(30,10,utf8_decode("F. colaboraciòn"),1,1,'C',True);

    include '../bd/conectar.php';

    $tiempo = time();
    $documento = 'documento'.$tiempo.'.pdf';

    $sql_colaboraciones = mysqli_query($conexion, "SELECT  u.id_usuario,
                                                           u.nombre_u,
                                                           u.email_u,
                                                           u.maravilla,
                                                           c.descripcion_colaboracion,
                                                           c.fecha_colaboracion,
                                                           c.id_colaboracion,
                                                           r.descripcion_reporte,
                                                           r.fecha,
                                                           r.estado_reporte,
                                                           r.captura,
                                                           r.observacion_r
                                                            FROM usuarios u
                                                            INNER JOIN colaboraciones_empresas c
                                                                ON u.id_usuario = c.id_empresa_usuario
                                                            INNER JOIN reportes r
                                                                ON r.id_reporte = c.id_reporte_c");

    $pdf->SetDrawColor(0,80,180);
    $pdf->SetFillColor(255,255,255);
    while($datos = mysqli_fetch_array($sql_colaboraciones)){
        $pdf->Cell(10,10,$datos['id_usuario'],1,0,'C');
        $pdf->Cell(40,10,$datos['maravilla'],1,0,'C');
        $pdf->Cell(40,10,$datos['nombre_u'],1,0,'C');
        $pdf->Cell(40,10,$datos['email_u'],1,0,'C');
        $pdf->Cell(30,10,$datos['descripcion_reporte'],1,0,'C');
        $pdf->Cell(30,10,$datos['fecha'],1,0,'C');
        $pdf->Cell(30,10,$datos['estado_reporte'],1,0,'C');

        $imagen = $datos['captura'];

        if($imagen != ''){
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            
            $pdf->Cell(30,10,'',1,0);
            $pdf->Image($imagen, $x+25, $y+1, 8, 8);
        }else{
            $pdf->Cell(30, 10, "Vacio", 1, 0, 'C');
        }

        $pdf->Cell(30,10,$datos['observacion_r'],1,0,'C');
        $pdf->Cell(30,10,$datos['descripcion_colaboracion'],1,0,'C');
        $pdf->Cell(30,10,$datos['fecha_colaboracion'],1,1,'C');
    }



    $pdf->Output('D', $documento);
?>