<?php
	require "connect.php";  //connect to your server here
	session_start();
	
	$username = mysqli_real_escape_string($connection, $_POST['login-username']);  //grab input from login and sanitize
	$password = mysqli_real_escape_string($connection, $_POST['login-password']);

	$pass_query = "SELECT password FROM user_data WHERE username='$username'";
	$pass_result = mysqli_query($connection, $query);
	$pass_row = mysqli_fetch_assoc($pass_result);
	$fetched_pass = $pass_row["password"];  //grab password hash from database to view
	$pass_check = password_verify($password, $fetched_pass);  //check if the passwords match
	
	if ($pass_check) {  //if so...
		$username_query = "SELECT username FROM user_data WHERE user_key = '$user_key'";
		$username_result = mysqli_query($connection, $username_query);
		$username_row = mysqli_fetch_assoc($username_result);
		$fetch_username = $username_row["username"];  //grab username
		$new_key = $fetch_username . hash("sha512", uniqid($fetch_username, true));  //generate new key
		$key_query = "UPDATE user_data SET user_key = '$new_key' WHERE username = '$fetch_username'";  //and then set it
		mysqli_query($connection, $key_query);
		setcookie("key", $new_key, time()+60*60*24*365, "/");  //set the key cookie
		$_SESSION["username"] = $fetch_username;  //set session username
	} else {  //invalid credentials
		setcookie("key", "", time()-3600, "/");  //remove cookie
	}
	header("Location: /");  //redirect to home
?>
