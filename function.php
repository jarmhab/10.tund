<?php
	require_once("../configglobal.php");
	require_once("User.class.php");
	$database = "if15_jarmhab";
	session_start();
	
	//loome ab yhenduse
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//Uus instants klassist User
	$User = new User($mysqli);
	
	
	
	
	
	
	
?>