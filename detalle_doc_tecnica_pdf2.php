<?php
require_once('libs/php/tcpdf/tcpdf.php');
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gonzalo Grupe A.');
$pdf->SetTitle('Reporte de Documentación Técnica.');
$pdf->SetSubject('Reporte de Documentación Técnica.');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$image_logo='../../../../img/logo_reporte.jpg';
$image_barra = '../../../../img/reporte_barra.jpg';
$titulo="Reporte de Documentación Técnica.";
$fecha=date('d-m-Y');

// set default header data
$pdf->SetHeaderData($image_logo, PDF_HEADER_LOGO_WIDTH, $titulo, $fecha);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<h1>Reporte de documentaci&oacute;n T&eacute;cnica.</h1>
&nbsp;&nbsp;&nbsp;Página: '.json_decode($_POST['pagina']).'.
<br/><br/><br/>
<table border="1" cellspacing="0" cellpadding="4" style="border-color:#DADADA;">
	<tr>
		<td style="width:50px; background-color:#32cd32; color:#ffffff;">
			<center><strong>N°</strong></center>
		</td>
		<td style="width:100px; background-color:#32cd32; color:#ffffff;">
			<center><strong>Usuario</strong></center>
		</td>
		<td style="width:100px; background-color:#32cd32;color:#ffffff;">
			<center><strong>Fecha</strong></center>
		</td>
		<td style="width:auto; background-color:#32cd32; color:#ffffff;">
			<center><strong>Informaci&oacute;n</strong></center>
		</td>
	</tr>';
	//$datos=[{"id":"1","usuario":"ggrrupe","fecha":"2013-06-19","detalle":"aqui va el detalle del descripcion de manera mas extensa. La idea es que ocupe más de una linea y probar el salto de linea en el pdf."},{"id":"2","usuario":"ggrupe","fecha":"2013-06-20","detalle":"aquí­ va la información de país"},{"id":"4","usuario":"ggrupe","fecha":"2013-06-20","detalle":"detalle"}];
	$data = [];
	$data = json_decode($_POST["datos"]);
	$largo_arr = 10;
	$largo_arr=count($data);
	$control=0;
	$color=0;
	$numero=1;
	$td="<td style='background-color:#FFFFFF;color:#000000;'>";
	while($control < $largo_arr)
	{
		if($color==2)
		{
			$tr="<tr style='background-color:#e7ffe0;color:#000000;'>";
			$td="<td style='background-color:green;'>";
			$color=0;
		}
		else
		{
			$tr="<tr style='background-color:#FFFFFF;color:#000000;'>";
			$td="<td style='background-color:green;'>";
		}
		$html.='<tr>'.$td.$numero.'</td>'.$td.$data[$control]->usuario.'</td>'.$td.$data[$control]->fecha.'</td>'.$td.$data[$control]->detalle.'</td></tr>';
		$control++;
		$color++;
		$numero++;
	}
$html.='</table><br/><br/><br/><br/><i>Documento Generado con fecha: '.$fecha."</i>";

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>