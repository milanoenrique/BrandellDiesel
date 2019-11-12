<?php
    include_once './connection.php';
    include_once 'log_generator.php';
    $data = $_POST['data'];
    $idrequest = $_POST['id_request'];

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
        $parts[] = array
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
        echo json_encode($parts);	
    }
    else
    {
         echo  json_encode($return2);  
    }
?>