<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    include 'message_status.php';
    include_once 'log_generator.php';
    
    $v              = $_POST['data'];
    $valor          = explode("|", $v);

    $idrequest      = $valor[0];
    $jobnumber      = $valor[1];
    $appuser        = $valor[2];
    $idrequesttype  = $valor[3];
    $idpriority     = $valor[4];
    $ro             = $valor[5];
    $vin            = $valor[6];
    $trans          = $valor[7];
    $engine         = $valor[8];
    $comments       = $valor[9];
    $json_parts     = $valor[10];
    $new_parts      = $valor[11];

    if ($new_parts=='[]'){
        $new_parts = null;

    }
       if ($json_parts=='[]'){
        $json_parts = null;

    }
  
  

      $sth = $dbh->prepare("SELECT * FROM json_update_req_parts(:idrequest,:json_parts::json,:jobnumber,:appuser,:idrequesttype,:idpriority,:ro,:vin,:trans,:engine,:comments, :new_parts::json);");
 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);  
    $sth->bindParam(':json_parts',      $json_parts,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':jobnumber',       $jobnumber,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idrequesttype',   $idrequesttype, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idpriority',      $idpriority,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':ro',              $ro,            PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':vin',             $vin,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':trans',           $trans,         PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':engine',          $engine,        PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':comments',        $comments,      PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':new_parts',      $new_parts,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

    $sth->execute();

    $error = $sth->errorInfo();
    if($error[0]!='00000'){
       log_bd($error[1].$error[2]);
    }else{
        log_bd('transaction successfully');
    }




    

    $return[] = array
    (
        'RESULTADO'                 => "00000", 
        'MENSAJE'                   => "ROW UPDATED"
    );
    $return2[] = array
    (
        'RESULTADO'                 => $error[0], 
        'MENSAJE'                   => "FAIL"
    );

    if( $error[0]==='00000')
    {	
        echo json_encode($return);	
    }
    else
    {
         echo  json_encode($return2);  
    }

        
       
