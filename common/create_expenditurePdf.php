<?php

	require('../fpdf/fpdf.php');    
    include_once './connection.php';
    
    $data = $_POST['expenditure'];
    $action = $_POST['action'];
    $id_expenditure = $_POST['id'];

    $sth=$dbh->prepare("select * from show_expenditure(:inidexpenditure);");
    $sth->bindParam(':inidexpenditure',       $id_expenditure,    PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
	$sth->execute();
	$retorno = $sth->fetchAll();
    $expenditure = [];
	foreach ($retorno  as $row) {
        $row['starting_date']=($row['starting_date']=='infinity')?'':$row['starting_date'];
        $row['anticipated_date']=($row['anticipated_date']=='infinity')?'':$row['anticipated_date'];
        $row['date_request']=($row['date_request']=='infinity')?'':$row['date_request'];
        $row['president_date_approved']=($row['president_date_approved']=='infinity')?'':$row['president_date_approved'];
        $row['cfo_date_approved']=($row['cfo_date_approved']=='infinity')?'':$row['cfo_date_approved'];
		$data[] = array
        (
            'id'                     => $row['id'],
            'project_name'           => $row['project_name'],
            'afe_number'             => $row['afe_number'],
            'description'             =>$row['description'],
            'starting_date'          => $row['starting_date'],
            'anticipated_date'       => $row['anticipated_date'],
            'amount'                 => $row['amount'],
            'request_by'             => $row['request_by'],
            'request_signature'      => $row['request_signature'],
            'date_request'           => $row['date_request'],
            'support_documentation'  => $row['support_documentation'],
            'president_name'         => $row['president_name'],
            'president_signature'    => $row['president_signature'],
            'president_date_approved'=> $row['president_date_approved'],
            'cfo_name'               => $row['cfo_name'],
            'cfo_signature'          => $row['cfo_name'],
            'cfo_date_approved'      => $row['cfo_date_approved'],
            'support_documentation'  => $row['support_documentation'],
        );
	}
	
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
    
    $cadena="Start_date: ".$data['start_date'];
	$pd->Cell(85,0,$cadena,0,0,'L');	
	
		
	$cadena="Anticipated date: ".$data['anticipated_date'];
    $pd->Cell(85,0,$cadena,0,0,'L');
    $pd->Ln(10);

	$cadena="Amount request: ".$data['amount_request'];
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
		$filename = '../PDF/expenditure_'.$id_expenditure.'.pdf';
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