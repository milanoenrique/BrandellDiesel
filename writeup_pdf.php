<?php

    header('Content-Type: text/html; charset=utf-8');    
	require('../fpdf/fpdf.php');    
    include_once './connection.php';
    
    $v                  = filter_input(INPUT_GET,'v', FILTER_SANITIZE_STRING); 		
    $valor              = explode("|", $v);
    $m 					= filter_input(INPUT_GET,'m', FILTER_SANITIZE_STRING);
	
    switch ($m) {
    	case 'writeup_update':
    		$pos1=14;
    		$pos2=13;
    		break;

    	case 'writeup_saveclose':
    		$pos1=14;
    		$pos2=13;
    		break;
    	
    	default:
    		$pos1=13;
    		$pos2=14;
    		break;
    }

		//error_log($v, 0);
	$writeupdate	 = $valor[0];
    $employee        = $valor[1];	
	$department      = $valor[2];		
    $supervisor   	 = $valor[3];        
    $senioritydate   = $valor[4];
    $tradelevel      = $valor[5];
    $disaction       = $valor[6];
    $violationtype   = $valor[7];
    $lastwarn 	 	 = $valor[8];
	$previouswarn	 = $valor[9];
	$warnings		 = $valor[10];
	$wpstatement	 = $valor[11];	
	$appuser       	 = $valor[12];
	$action			 = $valor[$pos1];	
	$idwriteup		 = $valor[$pos2];	
		
	$violationtypes = explode(",", $violationtype);	
	
	class PDF extends FPDF
	{
	// Cabecera de página
	function Header()
	{
		$this->Ln(8);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,0,'BDI - EMPLOYEE WRITE UP FORM',0,0,'L');
		$this->Image("../images/logo_bdi_izq.png",172,20,35,35);
		$this->Ln(15);	
	}

	// Pie de página
	function Footer()
		{
		$this->SetY(210);$this->SetFont('Arial','I',8);
		$this->Cell(0,100,'Brandell Diesel Inc.',0,0,'C');
		$this->Cell(0,100,'Page '.$this->PageNo().'/{nb}',0,0,'R');
		}
	}	
	
	$pd=new PDF('P',base64_decode('bW0='),array(215,278));

	$pd->AddPage();
	$pd->AliasNbPages();
	$pd->SetAutoPageBreak(true,20);		
	$pd->SetFont('Arial','',10);
	
	$cadena="Employee: ".$employee;
	$pd->Cell(85,0,$cadena,0,0,'L');
	$cadena="Date: ".$writeupdate;
	$pd->Cell(85,0,$cadena,0,0,'L');
	$pd->Ln(10);
	

	$cadena="Department: ".$department;
	$pd->Cell(85,0,$cadena,0,0,'L');
	$cadena="Supervisor: ".$supervisor;
	$pd->Cell(85,0,$cadena,0,0,'L');	
	$pd->Ln(10);
	
		
	$cadena="Employee Seniority Date: ".$senioritydate;
	$pd->Cell(85,0,$cadena,0,0,'L');
	$cadena="Trade level: ".$tradelevel;
	$pd->Cell(85,0,$cadena,0,0,'L');	
	$pd->Ln(10);

	
	$cadena="Disciplinary action: ".$disaction;
	$pd->Cell(69,0,$cadena,0,0,'L');	
	$pd->Ln(10);

	$yinit = $pd->GetY();
	$pd->Line(10,$yinit,205,$yinit);	
	$pd->Ln(10);	
	$pd->SetFont('Arial','B',10);
	$cadena="TYPE OF VIOLATION: ";
	$pd->Cell(95,0,$cadena,0,0,'L');	
	$cadena="WARNING: ";
	$pd->Cell(95,0,$cadena,0,0,'L');	
	$pd->Ln(10);
	$yinit = $pd->GetY();
	$pd->SetFont('Arial','',10);
	
	foreach($violationtypes as $rowv) 
    {
		$pd->Cell(65,0,$rowv,0,0,'L');
		$pd->Ln(5);
	}	
	$ystatement = $pd->GetY();

	$pd->SetY($yinit);	
	$pd->SetX(105);
	$cadena= "Last warning: ".$lastwarn;
	$pd->Cell(95,0,$cadena,0,0,'L');		
	$pd->Ln(5);
	$pd->SetX(105);	
	$cadena= "Previous warning: ".$previouswarn;
	$pd->Cell(95,0,$cadena,0,0,'L');		
	$pd->Ln(5);	
	$pd->SetX(105);	
	$cadena= "Warnings: ".$warnings;
	$pd->Cell(95,0,$cadena,0,0,'L');	
	$pd->Ln(5);		
	$yinit = $pd->GetY();

	if ($ystatement > $yinit) {
		$pd->SetY($ystatement);	
		$yline = $ystatement;
	}
	else
	{
		$pd->SetY($yinit);	
		$yline = $yinit;
	}
	
	$yline = $yline + 5;
	$pd->Line(10,$yline,205,$yline);
	$pd->Ln(10);	
	$pd->SetFont('Arial','B',10);
	$cadena="EMPLOYER STATEMENT:";
	$pd->Cell(20,0,$cadena,0,0,'L');
	$pd->Ln(5);
	$pd->SetFont('Arial','',10);
	$cadena=$wpstatement;
	$pd->MultiCell(0, 5, $cadena, 0, 'L', 0);
	$pd->Ln(5);		
	$yinit = $pd->GetY();
	$pd->Line(10,$yinit,205,$yinit);
	$pd->Ln(2);
	
	$pd->SetFont('Arial','',8);
	$cadena='I HAVE READ THIS "WARNING LETTER" AND I UNDERSTAND IF I HAVE RECIEVED A COPY OF THE SAME';
	$pd->MultiCell(0, 7, $cadena, 0, 'C', 0);
	$pd->SetFont('Arial','',10);
	$pd->Ln(30);	
	$cadena="___________________________					___________________________";
	$pd->Cell(0,0,$cadena,0,0,'C');
	$pd->Ln(5);	
	$cadena="	Employee Signature									Management Signature";
	$pd->Cell(0,0,$cadena,0,0,'C');
	$pd->Ln(10);	
	$cadena="___________________________";
	$pd->Cell(0,0,$cadena,0,0,'C');
	$pd->Ln(5);	
	$cadena="Witness Signature";
	$pd->Cell(0,0,$cadena,0,0,'C');	
	
	if ($action == 'view')
	{
		$pd->Output('I','writeup.pdf');
	}
	else
	{
		$archivo = null;
		$filename = '../PDF/writeup_'. $idwriteup.'.pdf';
		unlink($filename);
		$pd->Output('f',$filename); 
		
		if(isset($_GET["callback"]))
		{	
			echo $_GET["callback"]."(" . json_encode($filename) . ");";	
		}
		else
		{
			echo  json_encode($filename);
		}
	
	}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

  