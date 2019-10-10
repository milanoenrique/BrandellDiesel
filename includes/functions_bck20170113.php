<?php
/*
class Users {
	public $tableName = 'users';
	
	function __construct(){
		//database configuration
		$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'root'; //Define database username
		$dbPassword = ''; //Define database password
		$dbName = 'brandelldiesel'; //Define database name
		
		//connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0){
			$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}else{
			$insert = mysqli_query($this->connect,"INSERT INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}
}
*/
	//$vPath = "../";
	//include "$vPath"."pdodb.php";
	
	function getPDO_DB($SP) {
		
		$dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');
		$sth = $dbh->prepare($SP);
		$sth->execute();
		$retorno = $sth->fetchAll();
		
		return $retorno;
	}
		
	function getValidateUser($user, $pass, $userType, $status) {
		
		$retorno = getPDO_DB("select * from user_lookup('".$user."','".$pass."','".$userType."','".$status."');");
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			$returnDB = array
			(
				'fullNameUser' 	=> $row['surname']." ".$row['lastname'],
				'idUser'     	=> $row['iduser']."",
				'name' 			=> $row['name']."",
				'rol' 			=> $row['rol']."",
				'status'		=> 'success'
			);
		/*
			$_SESSION['fullNameUser'] = $row['surname']." ".$row['lastname'];
			echo $row['surname']." ".$row['lastname']."<br>";
			$_SESSION['idUser'] = $row['iduser'];
			echo $row['iduser']."<br>";
			$_SESSION['name'] = $row['name'];	
			echo $row['name']."<br>";
*/			
		}
		return $returnDB;
	}
	
	//$resultArray = getValidateUser('ptech1', '123456', 'A', 'A');	
?>