<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $m = filter_input(INPUT_GET,'m', FILTER_SANITIZE_STRING);
		  
    if ($m === "writeup_update"){
        $finalstatus='A';
    }else{
        $finalstatus='C';
    }	
        $v                  = $_GET['v']; 		
        $valor              = explode("|", $v);

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
        $idwriteup       = $valor[13];

        $sth = $dbh->prepare("SELECT * FROM writeup_update(:idwriteup,:writeupdate,:employee,:department,:supervisor,:tradelevel,:senioritydate,:violationtype,:lastwarn,:previouswarn,:disaction, :warnings,:wpstatement,:status,:appuser);");

        $sth->bindParam(':idwriteup',       $idwriteup,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':writeupdate', 	$writeupdate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':employee',   		$employee, 		PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':department',  	$department,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':supervisor', 		$supervisor,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':tradelevel',      $tradelevel,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);		
        $sth->bindParam(':senioritydate',	$senioritydate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':violationtype',   $violationtype, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':lastwarn',    	$lastwarn,  	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':previouswarn',	$previouswarn,  PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':disaction',       $disaction,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':warnings',        $warnings,      PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':wpstatement',     $wpstatement,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':status',          $finalstatus,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':appuser',        	$appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		
        $sth->execute();
        $return = $sth->fetchColumn(0);

        if(isset($_GET["callback"]))
        {	
            echo $_GET["callback"]."(" . json_encode($return) . ");";	
        }
        else
        {
            echo  json_encode($return);
        }
    
    
    