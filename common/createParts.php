<?php

    header('Content-Type: text/html; charset=utf-8');
    include_once 'log_generator.php';
    
    include_once './connection.php';
    
    $m = filter_input(INPUT_POST,'m', FILTER_SANITIZE_STRING);
    $security=0;
    $insert_request = false;
    $insert_parts= false;
    $result = null;
    
    if ($m === "request_insert")
    {
        $v                  = filter_input(INPUT_POST,'v', FILTER_SANITIZE_STRING); 
        $valor              = explode("|", $v);

        $jobnumber       = $valor[0];
        $appuser         = $valor[1];
        $idrequesttype   = $valor[2];
        $idpriority      = $valor[3];
        $ro              = $valor[4];
        $vin             = $valor[5];
        $trans           = $valor[6];
        $engine          = $valor[7];
        $comments        = $valor[8];

       
            $sth = $dbh->prepare("SELECT * FROM request_insert(:jobnumber,:appuser,:idrequesttype,:idpriority,:ro,:vin,:trans,:engine,:comments);");

        $sth->bindParam(':jobnumber',       $jobnumber,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':idrequesttype',   $idrequesttype, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':idpriority',      $idpriority,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':ro',              $ro,            PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':vin',             $vin,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':trans',           $trans,         PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':engine',          $engine,        PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':comments',        $comments,      PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

        $sth->execute();
        $result = $sth->fetchColumn(0);

             $error = $sth->errorInfo();
            if($error[0]!='00000')
            {
               log_bd("Insert_Request: ".$error[1].$error[2]);
               $insert_request = false;
            }else
            {
                log_bd('"Insert_Request: transaction successfully');
                $insert_request = true;
            }
        

        
    }
    
    if ($m === "request_parts_insert" && $security==0)
    {
        $v          = $_POST['v'];
        $valor      = explode("|", $v);
        $idrequest  = $valor[0];
        $parts      = $valor[1];
        $appuser    = $valor[2];
        $ordParts   = $valor[3];


        $partsDecode = json_decode($parts);

        foreach($partsDecode as $part)
        {
            $seg            = $part -> seg;
            $parts          = $part -> parts;
            $description    = $part -> description;
            $qty            = $part -> qty;
            $ord            = $part -> ord;
            //add date of delivery and comment of parts 08-01-2019
            $date_of_delivery = $part -> date_of_delivery;
            $comments_parts = $part -> comments_parts;
		  if($date_of_delivery=='')
          {
                $date_of_delivery=null;
          }
            
            $sth = $dbh->prepare("SELECT * FROM request_parts_insert(:idrequest,:seg,:parts,:description,:qty,:ord,:appuser,:dateofdelivery,:comment_parts);");
            
            $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':seg',             $seg,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':parts',           $parts,         PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':description',     $description,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':qty',             $qty,           PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':ord',             $ord,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':dateofdelivery',  $date_of_delivery,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->bindParam(':comment_parts',   $comments_parts,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

            $sth->execute();

            $error = $sth->errorInfo();
                if($error[0]!='00000')
                {
                   log_bd("Insert_Parts: ".$error[1].$error[2]);
                   $insert_parts = false;
                }else
                {
                    log_bd('"Insert_Parts: transaction successfully');
                    $insert_parts = true;
                }
        }
        


        
     
        if(!empty($ordParts)){
            $ord_temp= explode(',', $ordParts);
            $limit = count($ord_temp);
            $i=0;
            $j=0;
            while($i<$limit-1){
                $j=$i+1;
                $sth = $dbh->prepare("SELECT * FROM update_status_part(:inpart, :instatus);");
                $sth->bindParam(':inpart', $ord_temp[$i], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                $sth->bindParam(':instatus', $ord_temp[$j], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                $sth->execute();     
                $i++;
            }
        }

     
    }
                $return[] = array
        (
            'REQUEST'                 => $insert_request,
            'IDREQUEST'               => $result, 
            'PARTS'                   => $insert_parts
        );

        echo json_encode($return);