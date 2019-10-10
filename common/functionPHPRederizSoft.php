<?php	
	/****************************************************/
	/* rederizsoft - cp									*/
	/* rederizsoftdeveloper@gmail.com					*/
	/* www.rederizsoft.com								*/
	/****************************************************/
		
	function rederizsoftFunctionPDF($pd,$vRo,$vtechName,$vPriority,$vType,$vVin,$vComments,$vpartsJSON,$vDate,$vStatus,$eMail,$vEngine,$vID) {
		$pd->Addpage();
		$pd->AliasNbPages();
		//$pd->SetAutoPageBreak(true,20);	
		$pd->SetFont('Arial','',10);
		
		$vtechName = str_replace('&#39;', "'", $vtechName);
		


		$cadena="Tech name: ".$vtechName;
		$cadena = iconv('UTF-8', 'windows-1252', $cadena);
		$pd->Cell(15,0,$cadena,0,0,'L');

		$pd->Ln(7);

		$cadena="Type: ".$vPriority."        Priority: ".$vType;
		$cadena = iconv('UTF-8', 'windows-1252', $cadena);
		$pd->Cell(15,0,$cadena,0,0,'L');
		$pd->Ln(7);
		
		$cadena="Vin #: ".$vVin;
		$cadena = iconv('UTF-8', 'windows-1252', $cadena);
		$pd->Cell(15,0,$cadena,0,0,'L');
		$pd->Ln(7);
		
		$cadena="Engine #: ".$vEngine;
		$pd->Cell(19,0,$cadena,0,0,'L');
		$pd->Ln(7);
		
		$cadena="Comments:";
		$pd->Cell(19,0,$cadena,0,0,'L');
		$pd->Ln(3);
		$pd->SetFont('Arial','',10);
		$cadena=$vComments;
		$cadena = iconv('UTF-8', 'windows-1252', $cadena);

		$cadena = str_replace('&#39;', "'", $cadena);
		
		$pd->MultiCell(0, 7, $cadena, 0, 'L', 0);
		$pd->Ln(5);

		$cadena="PARTS:";
		$pd->Cell(19,0,$cadena,0,0,'L');	
		$pd->Ln(9);

		$pd->SetFont('Arial','U',10);
		$cadena="SEG";
		$pd->Cell(20,0,$cadena,0,0,'C');					
		$cadena="DESCRIPTION";

		$pd->Cell(75,0,$cadena,0,0,'C');	
		$cadena="QTY";
		$pd->Cell(30,0,$cadena,0,0,'C');	
		$pd->Ln(7);	
		
		$vpartsJSONtemp = explode("||", $vpartsJSON);
		//var_dump($vpartsJSON);
		//echo "<br><br>";

		//var_dump($vpartsJSONtemp);

		//echo "otro<br><br>";

		//var_dump($vpartsJSONtemp[0]);		
		$partsDecode = json_decode($vpartsJSONtemp[0]);
		$i=0;
		foreach($partsDecode as $parts)
		{   
			$w = 2;
			$y_temp= 0;

			$seg            = $parts -> seg;
			(property_exists($parts,"part")) ? $part=$parts->part : $part=$parts->parts;
			$description    = $parts -> description;
			(property_exists($parts,"quantity")) ? $quantity=$parts->quantity : $quantity=$parts->qty;
			$ord            = $parts -> ord;
			$pd->SetFont('Arial','',8);
			//$pd->SetY(10); /* Inicio */
			$cadena=$seg;
			$x=$pd->GetX(); $y=$pd->GetY();          
			$pd->MultiCell(20,2,$cadena,0,'C');	
			 $pd->SetXY($x+25,$y); 
			$cadena=$description;
			$cadena = iconv('UTF-8', 'windows-1252', $cadena);
			
			if(strlen($cadena)>75){
				$w=3;
				$y_temp = 10;
			}
			

			$cadena = str_replace('&#39;', "'", $cadena);
			$x=$pd->GetX(); $y=$pd->GetY(); 
			$pd->MultiCell(70,$w,$cadena,0,'C');
			$pd->SetXY($x+80,$y); 
			$cadena=$quantity;
			$pd->MultiCell(10,2,$cadena,0,'C');	

			$pd->SetY($pd->GetY()+$y_temp);
			$pd->Ln(7);
			if ($pd->GetY()>179){
				$pd->Addpage();
					$pd->AliasNbPages();
					$pd->SetAutoPageBreak(true,20);	
					$pd->SetFont('Arial','',10);
					$i=0;
			}






		}
		
		$archivo = null;
		$pd->Output('f','../PDF/request_'.$vRo.'_'.$vID.'.pdf'); /* File name and directory PFD 09-01-2017 */


		
	}

	function rederizsoftFunctionMail($vtechName,$eMail,$from,$fromName,$pass,$mail,$subject,$body,$vRo,$vID,$vDate,$dir,$vStatus,$time,$dbh) {
		
		
		

       
		$eMail = $mail;
		$mail->SMTPDebug = 0;                               
		$mail->isSMTP();                                   
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true;                           
		$mail->Username = $from;                 
		$mail->Password = $pass;                           
		$mail->SMTPSecure = "tls";                           
		$mail->Port = 587;
		$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);                                   
		
		$mail->AddAttachment('../PDF/request_'.$vRo.'_'.$vID.'.pdf');
		
		$mail->From = $from;
		$mail->FromName = $fromName;

		$sth = $dbh->prepare("SELECT * FROM mail_lookup(:vStatus);");
		$sth->bindParam(':vStatus',$vStatus,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
		$sth->execute();

		$retorno = $sth->fetchAll();
		$recepientName=null;
		foreach($retorno as $row) 
		{
			$recepientMail=$row['idmail'];
			$recepientName=$row['surname'].' '.$row['lastname'];
			$mail->addAddress($recepientMail, $recepientName);
		}

		$mail->isHTML(true);

		$mail->Subject = str_replace( '<Tech Name>',$vtechName, str_replace( '<Job Number>',$vRo, $subject ) );
		$mail->Body = $body;

		$mailResults=null;
		if(!$mail->send()) 
		{
			$mailResults= "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			$mailResults= "Message has been sent successfully";
		}
		phpAlert($mailResults);
	}

	function phpAlert($msg) {
		echo json_encode(array("msn" => $msg));
	}


