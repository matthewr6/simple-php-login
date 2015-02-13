<?php
	require "connect.php";  //connect to your server here
	
	$username = mysqli_real_escape_string($connection, $_POST['login-username']);
	$password = mysqli_real_escape_string($connection, $_POST['login-password']);

	$pass_query = "SELECT password FROM user_data WHERE username='$username'";
	$pass_result = mysqli_query($connection, $query);
	$pass_row = mysqli_fetch_assoc($pass_result);
	$fetched_pass = $pass_row["password"];
	$pass_check = password_verify($password, $fetched_pass);
	
	if ($pass_check) {  //can log in?  then do so
		$username_query = "SELECT username FROM user_data WHERE user_key = '$user_key'";
		$username_result = mysqli_query($connection, $username_query);
		$username_row = mysqli_fetch_assoc($username_result);
		$fetch_username = $username_row["username"];
		$new_key = $fetch_username . hash("sha512", uniqid($fetch_username, true));
		$key_query = "UPDATE user_data SET user_key = '$new_key' WHERE username = '$fetch_username'";
		mysqli_query($connection, $key_query);
		setcookie("key", $new_key, time()+60*60*24*365, "/");  //add domain/subdomain?
		$_SESSION["username"] = $fetch_username;
	} else {  //invalid credentials
		setcookie("key", "", time()-3600, "/");
	}
	header("Location: /");
?>
