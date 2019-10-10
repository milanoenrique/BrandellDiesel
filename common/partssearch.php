<?php
    header('Content-Type: text/html; charset=utf-8');    
    include_once './connection.php';
    
    $v              = $_GET['v'];
    $valor          = explode("|", $v);
    $iduser         = $valor[0];
    $startdate      = $valor[1];
    $enddate        = $valor[2];
    $jobnumber      = $valor[3];
    $keyword      	= $valor[4];
    
    $enddate = date ('Y-m-d');
    $enddate = date("Y-m-d",strtotime($enddate."+ 1 days"));
    $sql = "SELECT requests.jobnumber, parts.seg, parts.description, parts.quantity, initcap(parts.status_order)::character varying, parts.creation_date, parts.last_update_part from parts, requests
	where parts.idrequest = requests.idrequest and creation_date >= '".$startdate."' and parts.last_update_part <='".$enddate."' and (parts.description like '%".$keyword."%'  or requests.jobnumber like '%".$keyword."%')"; 
    //echo $sql;
    $sth = $dbh->prepare($sql); 

  
    
    $sth->execute();
    $retorno = $sth->fetchAll();
    $dashboard  = array();

    foreach($retorno as $row) 
    {
        $dashboard[] = array
        (
            'jobnumber_part'     => $row['jobnumber'],
            'seg_part'           => $row['seg'],
            'description_part'     => $row['description'],
            'quantity_part'      => $row['quantity'], 
			'status_order_part'  => $row['initcap'], 
            'creation_date_part'      => $row['creation_date'], 
            'last_update_part'    => $row['last_update_part']
        );
    }
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($dashboard) . ");";	
    }
    else
    {
        echo  json_encode($dashboard);
    }   