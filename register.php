<?php 
	require "connect.php";
	
	$taken = FALSE;
	$length = FALSE;
	$goodEmail = FALSE;
	$passCheck = FALSE;
	$goodUsername = FALSE;
	$maxUsernameLength = 50;
	$minPasswordLength = 5;
	
	$is_bot = false;
	
	$min_time = 1.5;  //minimum time before human confirmation
	
	if (empty($_POST)) {  //first registration request...
		$_SESSION['init_time'] = time();  //so set the beginning time
	} else {
		//check if enough time has passed
		$timediff = time() - $_SESSION['init_time'];  //find the difference in times
		if ($timediff <= $min_time) {  //time diff is too small!
			$is_bot = true;  //uh-oh, you're a bot!
		}
	}
	
	if (isset($_POST['username'], $_POST['password'], $_POST['password_check'], $_POST['email'])) {  //everything is set...
		$username = mysqli_real_escape_string($connection, $_POST['username']);  //no SQL injection
		
		$query = "SELECT username FROM user_data WHERE username='$username'";
		$result = mysqli_query($connection, $query);  //get username list for checking
		
		if (mysqli_num_rows($result) > 0) {
			$taken = TRUE;  //you don't want a taken username!
		}
		
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$goodEmail = TRUE;  //validate email
		}
		
		if ($_POST['password'] == $_POST['password_check'] && strlen($_POST['password']) > $minPasswordLength) {
			$passCheck = TRUE;  //good password...
		}
		
		if (strlen($_POST['username']) <= $maxUsernameLength && preg_match('/^[a-zA-Z0-9_-]*$/', $username)) {
			$goodUsername = TRUE;  //good username - length AND content!  (alphanumaric, _, and -)
		}
		
		if (!$taken && $goodEmail && $passCheck && $goodUsername && !$is_bot && isset($_SESSION['init_time'])) {
			//all is good, so register!
			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$hashedPassword = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT);
			$key = $username . hash("sha512", uniqid($username, true));
			
			//Can edit this to your preference.  Just keep the username, password, and user_key - those are the important ones!
			$query = "
				INSERT INTO user_data (username, password, email, user_key, date, ip, rank) 
				VALUES ('$username', '$hashedPassword', '$email', '$key', CURDATE(), '" . $_SERVER['REMOTE_ADDR'] . "', 'rank')
			";
			mysqli_query($connection, $query);
			
			//send registration mail
			$subject = '';  //whatever you want
			$message = '';  //whatever you want
			mail($email, $subject, $message);
		}
	}
?>
