<?php
	$is_logged_in = false;  //this variable is for displaying whatever you want later on.
	
	if (isset($_COOKIE["key"])) {  //check if the user still holds his/her cookie
		$key_query = "SELECT user_key FROM user_data WHERE user_key='" . $_COOKIE["key"] . "'";
		$key_result = mysqli_query($connection, $key_query);  //grab the cookie
		
		if (mysqli_num_rows($key_result) == 1) {  //should only be one in the database...
			//so then get data
			$login_query = "SELECT username FROM user_data WHERE user_key = '" . $_COOKIE["key"] . "'";
			$login_result = mysqli_query($connection, $login_query);
			$login_row = mysqli_fetch_assoc($login_result);
			if ($_SESSION["username"] != $login_row["username"]) {
				$_SESSION["username"] = $login_row["username"];  //set the username to fetched username
			}
			
			$is_logged_in = true;  //and you are logged in!
		} else {
			//logout, user key was not found
			unset($_SESSION['username']);
			$is_logged_in = false;
		}
	} else {
		unset($_SESSION['username']);
		$is_logged_in = false;
	}  //closing tag left out intentionally
