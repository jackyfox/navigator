<?php

	include ('ConnectionClass.php');
	
	class MainClass extends ConnectionClass{
		function isJSON($string) {
	    	return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
		}
		function addOtvet(){
			if (isset($_POST['name']) && isset($_POST['responseArray'])) {
				$name = $_POST['name'];
				//$name = preg_replace('%[^a-zа-я\d]%i', '', $name);
				$response = $_POST['responseArray'];

				$isJSON = $this->isJSON($response);
				if (!$isJSON) {					
					$result = "Произошла ошибка формата отправляемых данных";
					goto end;
				}
			}
			$isJSON = json_decode($response);
			$sum = $isJSON->summa;
			if(isset($_POST['language']) && $_POST['language'] == 'en'){
				if ($sum<=9 && $sum>0) {
					$direction = "agricultural technologies";
					$link = "https://profinavigator.ru";
				} else if ($sum<18) {
					$direction = "building systems technology";
					$link = "https://profinavigator.ru";
				} else if ($sum<24) {
					$direction = "informational technologies";
					$link = "https://profinavigator.ru";
				} else if($sum<29) {
					$direction = "space technologies";
					$link = "https://profinavigator.ru";
				} else if($sum<33) {
					$direction = "healthcare technologies";
					$link = "https://profinavigator.ru";
				} else if($sum<38) {
					$direction = "sport technologies";
					$link = "https://profinavigator.ru";
				} else if($sum<42) {
					$direction = "motion technology";
					$link = "https://profinavigator.ru";
				} else if($sum<46) {
					$direction = "material technologies";
					$link = "https://profinavigator.ru";
				} else if($sum<50) {
					$direction = "energy technologies";
					$link = "https://profinavigator.ru";
				} else {
					$direction = "environmental technologies";
					$link = "https://profinavigator.ru";
				}
			} else {
				if ($sum<=9 && $sum>0) {
					$direction = "аграрные технологии";
					$link = "https://profinavigator.ru";
				} else if ($sum<18) {
					$direction = "градостроительные технологии";
					$link = "https://profinavigator.ru";
				} else if ($sum<24) {
					$direction = "информационные технологии";
					$link = "https://profinavigator.ru";
				} else if($sum<29) {
					$direction = "космические технологии";
					$link = "https://profinavigator.ru";
				} else if($sum<33) {
					$direction = "технологии здоровья";
					$link = "https://profinavigator.ru";
				} else if($sum<38) {
					$direction = "технологии спорта";
					$link = "https://profinavigator.ru";
				} else if($sum<42) {
					$direction = "технологии движения";
					$link = "https://profinavigator.ru";
				} else if($sum<46) {
					$direction = "технологии материалов";
					$link = "https://profinavigator.ru";
				} else if($sum<50) {
					$direction = "технологии энергии";
					$link = "https://profinavigator.ru";
				} else {
					$direction = "экологические технологии";
					$link = "https://profinavigator.ru";
				}
			}

			//var_dump($_POST['languge']);
			$response = json_encode($response);
			$connect = $this->connect();
			if(isset($_POST['language']) && $_POST['language'] == 'en') {
				$la ='en';
		        $res = $connect->prepare("INSERT INTO `users`(`fio`, `response`, `value`, `direction`,`language`) VALUES (?,?,?,?,?)");
		        $res->execute(array($name,$response,$sum,$direction,$la));
	    	} else {
	    		$res = $connect->prepare("INSERT INTO `users`(`fio`, `response`, `value`, `direction`) VALUES (?,?,?,?)");
		        $res->execute(array($name,$response,$sum,$direction));
	    	}
	        $result = $connect->lastInsertId("id");

	        end:echo $result;
	    }
	    function getUser($user){
	    	$connect = $this->connect();
	        $res = $connect->prepare("SELECT * FROM `users` WHERE `id`=?");
	        $res->execute(array($user));
	        $result = $res->fetch(PDO::FETCH_ASSOC);
	        return $result;
	    }
	    
	}
	$main = new MainClass();
	if (isset($_POST['name']) && isset($_POST['responseArray']) && isset($_POST['language'])) {
		//echo('ok');
		$main->addOtvet();
	}

