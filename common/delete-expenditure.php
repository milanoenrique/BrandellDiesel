<?php 
    session_start();
    include_once './connection.php';
    $id_expenditure = $_POST['data'];
    $user = $_SESSION['getValidateUser']['idUser'];
    $sth=$dbh->prepare("select * from delete_expenditure(:inidexpenditure, :inuser);");
    $sth->bindParam(':inidexpenditure',       $id_expenditure,    PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':inuser', $user, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
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