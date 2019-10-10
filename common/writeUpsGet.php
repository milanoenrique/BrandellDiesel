<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v          = $_GET['v'];
    $idrequest  = $v;
    $request    = null;
    
    $sth = $dbh->prepare("SELECT * FROM writeups_get_lookup(:idwriteup);"); 
    $sth->bindParam(':idwriteup',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
        $trade=str_replace(',', '<br>', $row['violationtype']);

        $request= array
        (
            'writeupidwriteup'          => $row['idwriteup'],
            'writeupemployee'           => $row['employee'],            
            'writeupdate'               => date('Y-m-d',strtotime($row['writeupdate'])), 
            'writeupdepartment'         => $row['department'],      
            'writeupsupervisor'         => $row['supervisor'],        
            'writeuptradelevel'         => $row['tradelevel'],
            'writeupdisaction'          => $row['disaction'],
            'writeupviolationtype'      => $row['violationtype'],
            'writeuplastwarn'           => date('Y-m-d',strtotime($row['lastwarn'])),
            'writeuppreviouswarn'       => date('Y-m-d',strtotime($row['previouswarn'])),
            'writeupwpstatement'        => $row['wpstatement'],
            'writeupwarnings'           => $row['warnings'],
            'writeupsenioritydate'      => date('Y-m-d',strtotime($row['senioritydate']))
        );
    }

    $return['WRITEUP']=$request;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }