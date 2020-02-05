<?php
session_start();

ini_set('display_errors',-1); error_reporting(E_ALL);

include ('config.php');


class MainClass {

	function getCompanyInfo($idCompany) {
		$idCompany = (int)$idCompany;
		$query = "SELECT * FROM organisation WHERE id = $idCompany";
		$sql = $this->connect->query($query);
		$store = $this->connect->store_result();
		while($row = $sql->fetch_assoc()) {
			$company[] = $row;
		}

		return $company;
	}
 
 	function getTestInfo($idTest) {
 		$idTest = (int)$idTest;
		$query = "SELECT * FROM test WHERE id = $idTest";
		$sql = $this->connect->query($query);
		$store = $this->connect->store_result();
		while($row = $sql->fetch_assoc()) {
			$test[] = $row;
		}

		return $test;
	}

	function userInfo($userID) {
 		$userID = (int)$userID;
		$query = "SELECT * FROM user WHERE id = $userID";
		$sql = $this->connect->query($query);
		$store = $this->connect->store_result();
		while($row = $sql->fetch_assoc()) {
			$user[] = $row;
		}

		return $user;
	}

	function userAddLink($screen_name,$userId,$idTest) {
		$link = "https://profinavigator.ru/certificate/".$screen_name.".pdf";
		$query = "INSERT INTO user_link_certificate(id_user,link_certificate,id_test) VALUES ('$userId', '$link', '$idTest')";

			$find = "SELECT * FROM user_link_certificate WHERE id_user = $userId AND id_test = $idTest";
			$find_query = $this->connect->query($find);
			$store = $this->connect->store_result();
			$row = $find_query->fetch_assoc();

			if(!empty($row)) {
				return $row;
			}
			else {
				$add = $this->connect->real_query($query);
			}
	}
 
}

?> 
