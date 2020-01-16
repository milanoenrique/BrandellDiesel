<?php
session_start();
include_once './connection.php';

	$sth=$dbh->prepare("SELECT * from get_ticket_supports();");
	$sth->execute();
	$retorno = $sth->fetchAll();
    $ticket_support=[];
    $expenditure = [];
	foreach ($retorno  as $row) {
		$ticket_support[] = array
        (
            'id'                     => $row['id'],
            'edit'             => $row['id'],
            'subject'                => $row['subject'],
            'description'            => $row['description'],
            'created_by'             => $row['created_by'],
            //'updated_by'             => $row['updated_by'],
            'created_at'             => $row['created_at'],
            //'updated_at'             => $row['updated_at'],

        );
	}
	echo json_encode($ticket_support);