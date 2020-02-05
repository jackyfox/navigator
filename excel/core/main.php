<?php
class ConnectionClass{

	function connect()
	{
		$db = 'a0245025_app_profinavigator';
		$user ='a0245025_app_navigator';
		$pass ='OfXW9wlt';
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

class MainClass extends ConnectionClass {
	function getStatistic() {
    	$sql ="SELECT `user`.id, `user`.`username`, `user`.`first_name`, `user`.`last_name`, `user`.`patronymic`, `user`.`email`, `user`.`phone_number`,`user`.`updated_at`,
			IF(user.school = 0, '', organisation.name) as name,
            IF(profile_has_portfolio.link LIKE '%certForBiletGame.pdf%','true','false') as 'Сертификат',
            IF(user_has_group.group_id = 3,'true','false') as 'if_ped'
		    FROM `user` 
            LEFT JOIN organisation ON `user`.`school` = organisation.id 
            LEFT JOIN profile_has_portfolio ON `user`.`id` = profile_has_portfolio.id_user
            LEFT JOIN user_has_group ON user.id = user_has_group.user_id 
		    WHERE `user`.`updated_at` >= 1569888000
		";
		$connect = $this->connect();
		$res = $connect->prepare($sql);
		$res->execute();
		$result = $this->myFetchAll($res);
		return $result;
	}
}
