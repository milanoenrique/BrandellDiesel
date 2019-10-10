<?php
    header('Content-Type: text/html; charset=utf-8');    
	require('../fpdf/fpdf.php');
    include_once './connection.php';
  
    $v              = urldecode($_GET['v']);
    $valor          = explode("|", $v);
    $iduser         = $valor[0];
    $startdate      = $valor[1];
    $enddate        = $valor[2];
    $jobnumber      = $valor[3];
	$keyword      	= $valor[4];
	$loguser		= $valor[5];
	$action			= $valor[6];
	
		
	if ($startdate == '' && $enddate == '' && $jobnumber == '' && $keyword == '')
	{
		$sth = $dbh->prepare("SELECT * FROM dashboard_lookup_print(:iduser);"); 
		$sth->bindParam(':iduser',      $iduser,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
	}		
	else
	{
		$sth = $dbh->prepare("SELECT * FROM dashboard_lookup_print(:iduser,:startdate,:enddate,:jobnumber,:keyword);"); 
		$sth->bindParam(':iduser',      $iduser,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':jobnumber',   $jobnumber, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    };
		
    $sth->execute();
    $retorno = $sth->fetchAll();
    $dashboard  = array();
	
	
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	$this->SetFont('Arial','B',16);
	$this->Ln(8);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,'BDI - DASHBOARD',0,0,'C');
	$this->Ln(10);	
	$this->SetFont('Arial','',8);
	$this->Cell(15,0,'Job #',0,0,'C');	
	$this->Cell(15,0,'Type',0,0,'C');	
	$this->Cell(30,0,'Tech',0,0,'C');	
	$this->Cell(30,0,'Assigned to',0,0,'C');	
	$this->Cell(30,0,'Request date',0,0,'C');	
	$this->Cell(30,0,'Deadline',0,0,'C');		
	$this->Cell(15,0,'Status',0,0,'C');			
	$this->Cell(30,0,'Close date',0,0,'C');
	$this->Ln(10);
}

// Pie de página
function Footer()
{
$this->SetY(75);$this->SetFont('Arial','I',8);
$this->Cell(0,100,'Brandell Diesel Inc.',0,0,'C');
$this->Cell(0,100,'Page '.$this->PageNo().'/{nb}',0,0,'R');

}
}	
	$pd=new PDF('L',base64_decode('bW0='),array(215,139));
	
	//$pd =new FPDF();
	$pd->AddPage();
	$pd->AliasNbPages();
	$pd->SetAutoPageBreak(true,20);		
	
    foreach($retorno as $row) 
    {

			$pd->SetFont('Arial','',8);
			$cadena=$row['jobnumber'];
			$pd->Cell(15,0,$cadena,0,0,'C');
			$cadena=$row['requesttype'];
			$pd->Cell(15,0,$cadena,0,0,'C');			
			$cadena=$row['techname'];
			$pd->Cell(30,0,$cadena,0,0,'C');					
			$cadena=$row['assignedto'];
			$pd->Cell(30,0,$cadena,0,0,'C');				
			$cadena=$row['requestdate'];
			$pd->Cell(30,0,$cadena,0,0,'C');	
			$cadena=$row['deadline'];
			$pd->Cell(30,0,$cadena,0,0,'C');		
			$cadena=$row['status'];
			$pd->Cell(15,0,$cadena,0,0,'C');				
			$cadena=$row['closedate'];
			$pd->Cell(30,0,$cadena,0,0,'C');	
			$pd->Ln(7);		
		
    }    

	if ($action == 'view')
	{
		$pd->Output('I','dashboard.pdf');
	}
	else
	{
		$archivo = null;
		$filename = '../PDF/dashboard_'. $loguser.'.pdf';
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


