<?php
    session_start();
    include_once './connection.php';
    include_once 'log_generator.php';
    $data = $_POST['data'];
    $idrequest = $_POST['id_request'];
    
   
    $appuser = $_SESSION['getValidateUser']['idUser'];
    if(isset($_POST['new_part'])){
        $new_parts = $_POST['new_part'];
        $new_parts = json_decode($new_parts);
        foreach($new_parts as $new_part)
        {
            $seg            = $new_part->seg;
            $parts          = $new_part->part;
            $description    = $new_part->description;
            $qty            = $new_part->quantity;
            $ord            = $new_part->ord;
            //add date of delivery and comment of parts 08-01-2019
            $date_of_delivery = $new_part->date_of_delivery;
            $comments_parts = $new_part->comment_parts;
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
    }
   


    $sth = $dbh->prepare("SELECT * FROM json_update_massive_status(:json_parts::json,:idrequest);");
 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);  
    $sth->bindParam(':json_parts',      $data,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();

    $error = $sth->errorInfo();
    if($error[0]!='00000'){
       log_bd($error[1].$error[2]);
    }else{
        log_bd('transaction successfully');
    }

    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
       
        $sql = "select distinct comment, creation_date::timestamp::date from parts_log where idpart ='".$row['part']."' and comment !=''";
        $comment_log[] = array('part'    => $row['part'],
                                   'comment' =>'-',
                                    'date'   => '-');
        
        $sth=$dbh->prepare($sql);
        $sth->execute();
        $allcoments = $sth->fetchAll();
        foreach ($allcoments as $key) {
            $comment_log[] = array('part'    => $row['part'],
                                   'comment' =>$key['comment'],
                                    'date'   => $key['creation_date']);
        }
        $parts_1[] = array
        (
            'idrequest'     => $row['idrequest'], 
            'seg'           => $row['seg'], 
            'part'          => $row['part'], 
            'description'   => $row['description'], 
            'quantity'      => $row['quantity'], 
            'ord'           => $row['ord'],
            'edit'          => $row['idrequest']."|".$row['part'], 
            'delete'        => $row['idrequest']."|".$row['part'],
            'date_of_delivery' => $row['date_of_delivery'],
            'comment_parts' => $row['comments_parts'],
            'status'        => $row['status'],
            'allcoments'    => $comment_log,
            'real_date'     => $row['real_date']
        );
        unset($comment_log);
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
        echo json_encode($parts_1);	
    }
    else
    {
         echo  json_encode($return2);  
    }
?>