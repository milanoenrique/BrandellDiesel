<?php 
	function getPDO_DB($SP) {
		
		$dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');
		$sth = $dbh->prepare("SELECT * FROM dashboard_lookup('')");
		$sth->execute();
		$retorno = $sth->fetchAll();
		
		return $retorno;
	}
?>