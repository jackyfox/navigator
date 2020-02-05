<?php 

class ConnectionClass{
	//public $name = 'Connection';
	// php my admin https://pma.sprinthost.ru/index.php?server=1
	function connect()
	{
		$db = 'a0245025_temp_tests';
		$user ='a0245025_temp_tests';
		$pass ='QTm4P4N4';
		$dsn ='mysql:host=localhost;dbname='.$db.';charset=utf8';
		$driver_options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

		$pdo = new PDO($dsn, $user, $pass, $driver_options) or die ( 'error' );
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		return $pdo;
	}

	function myFetchAll($pdo)
	{
		$result = array();
		while ($row = $pdo->fetch(PDO::FETCH_ASSOC))
		{
			$result[] = $row;
		}
		return $result;
	}
}