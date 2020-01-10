<?php 
    include_once './connection.php';
    $id_expenditure = $_POST['data'];
    $sth=$dbh->prepare("select * from show_expenditure(:inidexpenditure);");
    $sth->bindParam(':inidexpenditure',       $id_expenditure,    PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
	$sth->execute();
	$retorno = $sth->fetchAll();
    $expenditure = [];
	foreach ($retorno  as $row) {
        $row['starting_date']=($row['starting_date']=='infinity')?'':$row['starting_date'];
        $row['anticipated_date']=($row['anticipated_date']=='infinity')?'':$row['anticipated_date'];
        $row['date_request']=($row['date_request']=='infinity')?'':$row['date_request'];
        $row['president_date_approved']=($row['president_date_approved']=='infinity')?'':$row['president_date_approved'];
        $row['cfo_date_approved']=($row['cfo_date_approved']=='infinity')?'':$row['cfo_date_approved'];
		$expenditure[] = array
        (
            'id'                     => $row['id'],
            'project_name'           => $row['project_name'],
            'afe_number'             => $row['afe_number'],
            'description'             =>$row['description'],
            'starting_date'          => $row['starting_date'],
            'anticipated_date'       => $row['anticipated_date'],
            'amount'                 => $row['amount'],
            'request_by'             => $row['request_by'],
            'request_signature'      => $row['request_signature'],
            'date_request'           => $row['date_request'],
            'support_documentation'  => $row['support_documentation'],
            'president_name'         => $row['president_name'],
            'president_signature'    => $row['president_signature'],
            'president_date_approved'=> $row['president_date_approved'],
            'cfo_name'               => $row['cfo_name'],
            'cfo_signature'          => $row['cfo_name'],
            'cfo_date_approved'      => $row['cfo_date_approved'],
            'support_documentation'  => $row['support_documentation'],
        );
	}
	echo json_encode($expenditure);

?>