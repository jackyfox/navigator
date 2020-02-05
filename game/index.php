<?php
	if (isset($_GET['hash'])) {
		$hash = $_GET['hash'];
		echo $hash;
		if (
			$hash == '9xTfXoMWKm15Jfln' ||
			$hash == 'kqN63Go_pyrEWED8' ||
			$hash == 'piriECnhUMd6B4Fi' ||
			$hash == 'MMT9G-ZuA52he8ah' ||
			$hash == '-Ekgp4TqPkjIkLIE' ||
			$hash == 'yEKHPuILcQgDyThx' ||
			$hash == 'g1wlyF0THWhzzW-C' ||
			$hash == 'RtvbGKP6WgFHckCq' ||
			$hash == 'HaR9wNeuOdCdNgzT' ||
			$hash == 'vXzF-S9WLZ4W1BzZ' 
		) {
			$value = 'KRxVuPXq5j38ZU';
			setcookie("gameCookie", $value, time()+1800, "/", "profinavigator.ru");
			header("Location: https://profinavigator.ru/login");
			exit;
			echo "success";
		} else {
			echo "параметр неверен";
			die();
		}	
	} else {
		echo "параметр не передан";
		die();
	}
?>
