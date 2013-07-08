<?php
//print_r(json_decode($_POST["datos"]));
require_once('libs/php/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Barra
                $image_barra = K_PATH_IMAGES.'../../../../img/reporte_barra.jpg';		
		$this->Image($image_barra, 10, 14, 190, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Logo 
                $image_file = K_PATH_IMAGES.'../../../../img/logo_reporte.jpg';
                $this->Image($image_file, 10, 8, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
		$this->SetFont('helvetica', 'B', 16);
                $this->SetXY(50,9);                
		$this->Cell(0, 15, 'Reporte de Registro de Datos', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $this->SetFont('helvetica', 'N', 10);
                $this->SetXY(50,18);
		$this->Cell(0, 15, 'Periodo del '.$_POST[finicial].' al '.$_POST[ffinal].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
                $barra = K_PATH_IMAGES.'../../../../img/reporte_barra_footer.jpg';		
		$this->Image($barra, 10, 285, 190, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Position at 15 mm from bottom
		$this->SetY(-13);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
                $this->SetXY(180,285);
		$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
                $this->SetXY(10,285);
                $this->Cell(0, 10, 'Sistema Integrado de Gestión de Proyectos', 0, false, 'L', 0, '', 0, false, 'T', 'M');
	}
        
        public function ColoredTable($header,$data) {
                $num_paginas = $this->getPage();
                $contador = 0;
		// Colors, line width and bold font
		$this->SetFillColor(182);
		$this->SetTextColor(255);
		$this->SetDrawColor(118, 118, 118);
		$this->SetLineWidth(0.2);
		$this->SetFont('helvetica', 'B', 10);
		// Header
		//$w = array(25, 30, 30, 30, 30,30);
		$num_headers = count($header);
                
                //$this->MultiCell(55, 5, '[LEFT] ', 1, 'L', 1, 0, '', '', true);
                
		for($i = 0; $i < $num_headers; ++$i) {
                    $this->MultiCell(30, 10, $header[$i], 1, 'C', 1, 0, '', '', true);
			//$this->Cell($w[$i], 16, $header[$i], 1, 0, 'L', 1, 0);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(233, 245, 238);
		$this->SetTextColor(0);
		$this->SetFont('helvetica', 'N', 9);
		// Data
		$fill = 0;
                //echo $data[0][0];
		for($i= 0; $i < count($data[0]); $i++) {
                    
                    $this->SetTextColor(0, 0, 0);
                    $this->Cell(30, 6, $data[0][$i]->fechas, 'LR', 0, 'C', $fill);
                    
                    for($j= 0; $j < count($data); $j++) {
//                        if($this->getPage() != $num_paginas){
//                            for($x = 0; $x < $num_headers; ++$x) {
//                                $this->MultiCell(30, 10, $header[$x], 1, 'C', 1, 0, '', '', true);
//                            }
//                            $this->Ln();
//                            
//                            $this->SetTextColor(0, 0, 0);
//                            $this->Cell(30, 6, $data[0][$i]->fechas, 'LR', 0, 'C', $fill);
//                            $num_paginas = $this->getPage();                    
//                        }
                    
			//$this->Cell(30, 6, number_format($data[$j][$i]->valor_real,2), 'LR', 0, 'R', $fill);
                        if($data[$j][$i]->color == 'Red' or $data[$j][$i]->color == 'red'){
                            $this->SetTextColor(255, 0, 0);
                        }else if($data[$j][$i]->color == 'Black'){
                            $this->SetTextColor(0, 0, 0);
                        }else if($data[$j][$i]->color == 'Black'){
                            $this->SetTextColor(0, 0, 0);
                        }else if($data[$j][$i]->color == 'DarkGray'){
                            $this->SetTextColor(153, 153, 153);
                        }else if($data[$j][$i]->color == 'LimeGreen'){
                            $this->SetTextColor(0, 236, 82);
                        }
                        $this->Cell(30, 6, $data[$j][$i]->valor_real, 'LR', 0, 'R', $fill);
                        $contador++;
                    }
                    
                    $this->Ln();                    
                    $fill=!$fill;
                    
		}
                
		//$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

// column titles
//json_decode($_POST["datos"])
$tmp = json_decode($_POST["titulos"]);
$header = $tmp;

// print a block of text using Write()
//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->Write(0, "En el siguiente cuadro se detalla los datos ingresado y sus estados (ver leyenda al pie de página) : ", '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
// data loading
$data = [];
$data = json_decode($_POST["datos"]);
//print_r($data[0][0]->valor_real);
$pdf->ColoredTable($header, $data);

$pdf->Output('example_011.pdf', 'I');
