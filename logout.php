<?php
	require "connect.php";  //again, connect
	
	setcookie("key", "", time()-3600, "/");  //destroy cookie
	
	$_SESSION = array();
	session_destroy();
	header("Location: /");
?>
