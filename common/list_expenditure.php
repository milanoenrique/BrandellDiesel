<?php 
	include_once './connection.php';

	$sth=$dbh->prepare("select * from get_expenditure();");
	$sth->execute();
	$retorno = $sth->fetchAll();
    $expenditure = [];
	foreach ($retorno  as $row) {
		$expenditure[] = array
        (
            'id'                     => $row['id'],
            'project_name'           => $row['project_name'],
            'starting_date'          => $row['starting_date'],
            'amount'                 => $row['amount'],
            'requested'  => $row['requested'],
            'requested_date' => $row['requested_date'],
            'approved_date'   => $row['approved_date']
        );
	}
	echo json_encode($expenditure);

?>