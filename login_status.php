<?php
	$is_logged_in = false;
	if (isset($_COOKIE["key"])) {
		$key_query = "SELECT user_key FROM user_data WHERE user_key='" . $_COOKIE["key"] . "'";
		$key_result = mysqli_query($connection, $key_query);
		
		if (mysqli_num_rows($key_result) == 1) {
			//get data and display
			$login_query = "SELECT username FROM user_data WHERE user_key = '" . $_COOKIE["key"] . "'";
			$login_result = mysqli_query($connection, $login_query);
			$login_row = mysqli_fetch_assoc($login_result);
			//$row = mysqli_fetch_assoc($login_result);
			if ($_SESSION["username"] != $login_row["username"]) {
				$_SESSION["username"] = $login_row["username"];
			}
			
			$is_logged_in = true;
		} else {
			//logout, user key was not found
			unset($_SESSION['username']);
			$is_logged_in = false;
		}
	} else {
		unset($_SESSION['username']);
		$is_logged_in = false;
	}  //closing tag left out intentionally
