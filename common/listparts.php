<?php 
	include_once './connection.php';

	$sth=$dbh->prepare("select * from status_order();");
	$sth->execute();
	$retorno = $sth->fetchAll();
    $parts = [];
	foreach ($retorno  as $row) {
		$parts[] = array
        (
            'jobnumber_part'     => $row['jobnumber_part'],
            'seg_part'           => $row['seg_part'],
            'description_part'   => $row['description_part'],
            'quantity_part'      => $row['quantity_part'],
            'status_order_part'  => $row['status_order_part'],
            'creation_date_part' => $row['creation_date_part'],
            'last_update_part'   => $row['last_update_part'],
            'idrequest'          => $row['idrequest'],
            'part'               => $row['part']
        );
	}
	//$part_list['order_status']= json_encode($retorno);
	if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($parts) . ");";	
    }
    else
    {
        echo  json_encode($parts);
    }

?>