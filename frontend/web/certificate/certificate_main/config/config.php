<?php

$main     = new MainClass();
$host     = 'localhost';
$user     = 'a0245025';
$password = 'uxdumawazi';
$db       = 'a0245025_app_profinavigator';

$main->connect = new MySQLi($host, $user, $password, $db);

$var = $main->connect;
$var->set_charset("utf8");

if ($var->connect_errno) {
	die('Connect Error ('.$connect->connect_errno.') '.$connect->connect_error);
}
?>