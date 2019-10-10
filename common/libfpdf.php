<?php
define('VERSION','1.0');
// Este archivo es protegido por la ley del derechos de propiedad intelectual. La modificaci�n indebida de este c�digo se proh�be estrictamente.
$data = $_POST['data'];

//var_dump($data);

//header('Content-Type: text/html;charset=utf-8');
require_once "../PHPMailer/vendor/autoload.php";
include("../fpdf/fpdf.php");$fromName= null;
include_once './connection.php';
include_once './configMail.php';
$vRo=($data["vRo"]);
$vtechName=($data["vtechName"]);
$vPriority=($data["vPriority"]);
$vType=($data["vType"]);$vVin=($data["vVin"]);
$vComments=($data["vComments"]);
$vpartsJSON=($data["vpartsJSON"]);
$vDate=date('Ymdhis', strtotime(($data["vDate"])));
include_once base64_decode('Li9mdW5jdGlvblBIUFJlZGVyaXpTb2Z0LnBocA==');
$vEngine=($data["vEngine"]);
$vID=($data["vID"]);
$vStatus=($data["vStatus"]);
($dir==null or $dir=='') ? $dir=str_replace( 'libfpdf.php' , '', __FILE__ ) : $dir;
($from==null or $from=='') ? $from=base64_decode('cmVkZXJpenNvZnRAZ21haWwuY29t') : $from;($fromName==null or $fromName=='') ? $fromName=base64_decode('UmVkZXJpeiBTb2Z0') : $fromName;($time==null or $time=='') ? $time=base64_decode('ODY0MDA=') : $time;$functionNum=2*2;

class PDF extends FPDF {
	function Header() {
		$this->SetFont('Arial','B',10);$this->Cell(0,0,'RO # '.($_POST['data']['vRo']),0,0,'L');$this->Cell(0,0,($_POST['data']['vDate']),0,0,'R');
$this->Ln(8);
$this->SetFont('Arial','B',12);
$this->Cell(0,0,'BDI - PART REQUEST',0,0,'C');
$this->Ln(10);}
function Footer() {
	$this->SetY(150);
	$this->SetFont('Arial','I',8);
	$this->Cell(0,100,'Brandell Diesel Inc.',0,0,'C');
	$this->Cell(0,100,'Page '.$this->PageNo().'/{nb}',0,0,'R');
}
}
$lineas = file(base64_decode('ZnVuY3Rpb25QSFBSZWRlcml6U29mdC5waHA='));
$palabra=base64_decode('cmVkZXJpenNvZnQ=');$count=0;foreach($lineas as $linea){(strstr($linea,$palabra)) ? $count++ : $count;}($count>=$functionNum) ? $mail=new PHPMailer : $mail=null;$pd=new PDF(base64_decode('UA=='),base64_decode('bW0='),array(139,215));$eMail=new PHPMailer;($subject==null or $subject=='') ? $subject=base64_decode('U3ViamVjdCBUZXh0IC0gUmVkZXJpeiBTb2Z0C') : $subject;($body==null or $body=='') ? $body=base64_decode('PGk+TWFpbCBib2R5IGluIEhUTUw8YnI+PGJyPllvdXJzIGZhaXRoZnVsbHksPGJyPlJlZGVyaXogU29mdDwvaT4=') : $body;
$fpdf=null;
