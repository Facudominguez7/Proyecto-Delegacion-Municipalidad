<?php

require('./fpdf/fpdf.php');


class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {
        //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

        //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
        //$dato_info = $consulta_info->fetch_object();
        $this->Image('fpdf/logo-delegacion.jpg', 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
        $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(45); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        //creamos una celda o fila
        $this->Cell(110, 15, ('Delegación Chacra 32-33'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); //color

         /* Delegado */
         $this->Cell(110);  // mover a la derecha
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(96, 10, ("Delegado : Rolando Olmedo"), 0, 0, '', 0);
         $this->Ln(5);

        /* UBICACION */
        $this->Cell(110);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(96, 10, ("Ubicación : Av. Gral. Lavalle 4637"), 0, 0, '', 0);
        $this->Ln(5);

        /* TELEFONO */
        $this->Cell(110);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(59, 10, ("Teléfono : 3764634383"), 0, 0, '', 0);
        $this->Ln(5);

        /* COREEO */
        $this->Cell(110);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(85, 10, ("Correo : Pepeolmedo291@gmail.com "), 0, 0, '', 0);
        $this->Ln(10);



        /* TITULO DE LA TABLA */
        //color
        $this->SetTextColor(228, 100, 0);
        $this->Cell(50); // mover a la derecha
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, ("REPORTE DE ACTIVIDAD "), 0, 1, 'C', 0);
        $this->Ln(7);

    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, ('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $this->Cell(355, 10, ($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
    }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

include_once './includes/conexion.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */

$pdf = new PDF('P', 'mm', 'A4', true);
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$fecha_actual = date('Y-m-d');
$consulta_reporte_actividad = $con->query("SELECT tareas.id, tareas.titulo, tareas.descripcion, tareas.fecha, chacras.nombre AS nombreChacra
                                           FROM tareas 
                                           INNER JOIN chacras ON tareas.idChacra = chacras.id 
                                           WHERE tareas.fecha = '$fecha_actual'");



while ($datos_reporte = $consulta_reporte_actividad->fetch_object()) {
    // Crear las celdas de la tabla para cada registro
    $pdf->Cell(18, 10, ('N°'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, ('CHACRA'), 1, 0, 'C', 0);
    $pdf->Cell(70, 10, ('TÍTULO'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, ('FECHA'), 1, 1, 'C', 0);

    // Contenido de cada celda
    $pdf->Cell(18, 10, ($datos_reporte->id), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, ($datos_reporte->nombreChacra), 1, 0, 'C', 0);
    $pdf->Cell(70, 10, ($datos_reporte->titulo), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, date('d/m/Y', strtotime($datos_reporte->fecha)), 1, 1, 'L', 0);

    // Obtener la descripción
    $descripcion = ($datos_reporte->descripcion);
    
    // Dibujar el campo de descripción debajo de la tabla
    $pdf->Cell(18+30+70+25, 10, ('Descripción:'), 'LTR', 1, 'C', 0); // Título del campo de descripción
    $pdf->MultiCell(18+30+70+25, 10, ($descripcion), 'LRB', 'C'); // Contenido del campo de descripción
    
    // Agregar un salto de línea después de cada registro
    $pdf->Ln(5);
}


$pdf->Output('Reporte.pdf', 'D');//nombreDescarga, Visor(I->visualizar - D->descargar)
