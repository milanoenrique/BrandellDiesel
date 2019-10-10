<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';

    $m = filter_input(INPUT_GET,'m', FILTER_SANITIZE_STRING);
    
    if ($m === "dashboard_ini")
    {	
		
		$sth = $dbh->prepare("SELECT * FROM writeups_lookup1();");
		
		$sth->execute();
		$retorno = $sth->fetchAll();
		$dashboardwp  = array();

		foreach($retorno as $row) 
		{

			$trade=str_replace(',', '<br>', $row['violationtype']);

			if ($row['status']!='D') {

				$dashboardwp[] = array
				(
					'writeupidwriteup'       	=> $row['idwriteup'],
					'writeupemployee'        	=> $row['employee'],			
					'writeupdate'	 	=> $row['writeupdate'],	
					'department'      	=> $row['department'],		
					'writeupsupervisor'   	 	=> $row['supervisor'],        
					'writeuptradelevel'      	=> $row['tradelevel'],
					'writeupdisaction'       	=> $row['disaction'],
					'writeupviolationtype'   	=> $trade,//$row['violationtype'],
					'writeuplastwarn' 	 		=> $row['lastwarn'],
					'writeuppreviouswarn' 		=> $row['previouswarn'],
					'writeupwarnings'		 	=> $row['warnings'],
					'view'          	=> $row['idwriteup'],
					'delete'        	=> $row['idwriteup'],
					'status'			=> $row['status']		
				);

			}
		}

		if(isset($_GET["callback"]))
		{	
			echo $_GET["callback"]."(" . json_encode($dashboardwp) . ");";	
		}
		else
		{
			echo  json_encode($dashboardwp);
		}
	}
	