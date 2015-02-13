<?php
	require "connect.php";  //again, connect
	session_start();
	
	setcookie("key", "", time()-3600, "/");  //destroy cookie
	
	$_SESSION = array();  //destroy session
	session_destroy();
	header("Location: /");  //redirect
?>
