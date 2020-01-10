<?php

	require('../fpdf/fpdf.php');    
    include_once './connection.php';
    
    $data = $_POST['expenditure'];
    $action = $_POST['action'];
    $id = $_POST['id'];

	
    //var_dump($data);

		//error_log($v, 0);

	
	
	class PDF extends FPDF
	{
	// Cabecera de página
	function Header()
	{
		$this->Ln(8);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,0,'BDI - EXPENDITURE',0,0,'L');
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
	
	$cadena="Project name: ".$data['project_name'];
	$pd->Cell(85,0,$cadena,0,0,'L');
	$cadena="AFE-Number: ".$data['afe_number'];
	$pd->Cell(85,0,$cadena,0,0,'L');
    $pd->Ln(30);

    $yinit = $pd->GetY();
	$pd->Line(10,$yinit,205,$yinit);	
	$pd->Ln(10);
    
    $cadena="Start_date: ".$data['starting_date'];
	$pd->Cell(85,0,$cadena,0,0,'L');	
	
		
	$cadena="Anticipated date: ".$data['anticipated_date'];
    $pd->Cell(85,0,$cadena,0,0,'L');
    $pd->Ln(10);

	$cadena="Amount request: ".$data['amount'];
	$pd->Cell(85,0,$cadena,0,0,'L');	
    $pd->Ln(10);
    
	$cadena="Request by: ".$data['request_by'];
	$pd->Cell(69,0,$cadena,0,0,'L');	
    $pd->Ln(10);


    
    $cadena="Project Description: ";
    $pd->Cell(85,0,$cadena,0,0,'L');
    $pd->Ln(10);
    
    $cadena = $data['description'];
    $pd->Cell(85,0,$cadena,0,0,'L');
    $pd->Ln(10);
    
    $pd->SetFont('Arial','',10);
	$cadena="Signature: ". $data['request_signature'];
	$pd->Cell(85,0,$cadena,0,0,'L');	
	$cadena="Date Request: ". $data['date_request'];
    $pd->Cell(45,0,$cadena,0,0,'L');
    $pd->Ln(10);

    $yinit = $pd->GetY();
	$pd->Line(10,$yinit,205,$yinit);	
    $pd->Ln(10);
    



    $cadena="President name: ". $data['president_name'];	
    $pd->Cell(85,0,$cadena,0,0,'L');
    $cadena="President signature: ". $data['president_signature'];	
    $pd->Cell(45,0,$cadena,0,0,'L');
    $cadena="President date approved: ". $data['president_date_approved'];	
    $pd->Cell(45,0,$cadena,0,0,'L');
    $pd->Ln(10);

    $cadena="CFO name: ". $data['cfo_name'];	
    $pd->Cell(85,0,$cadena,0,0,'L');
    $cadena="CFO signature: ". $data['cfo_signature'];	
    $pd->Cell(45,0,$cadena,0,0,'L');
    $cadena="CFO date approved: ". $data['cfo_date_approved'];	
    $pd->Cell(45,0,$cadena,0,0,'L');
	$pd->Ln(10);
	$yinit = $pd->GetY();
	$pd->SetFont('Arial','',10);
	
	
	$ystatement = $pd->GetY();

	
	
	
	
	
	
	if ($action == 'view')
	{
		$pd->Output('I','writeup.pdf');
	}
	else
	{
		$archivo = null;
		$filename = '../PDF/expenditure_'.$id.'.pdf';
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