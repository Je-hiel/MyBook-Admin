<?php 
    
	include('conn.php');
	
	$username = $_GET['username'];
	$email = $_GET['email'];
	$password = $_GET['password'];
	$first_name = $_GET['first_name'];
	$last_name = $_GET['last_name'];
	$date_of_birth = $_GET['date_of_birth'];
	
	
	// Checks if email is already in table
	$email_query = "SELECT * FROM user WHERE email = :email";
	$email_stmt = $db->prepare($email_query);
	$email_stmt->execute(['email' => $email]);

	// Checks if username is already in table
	$username_query = "SELECT * FROM user WHERE username = :username";
	$username_stmt = $db->prepare($username_query);
	$username_stmt->execute(['username' => $username]);
	

	if ($email_stmt->rowCount() > 0) {
		
		$errorMsg = 'Email already exists. Please try again with different email address.';

		echo json_encode($errorMsg);

	} else if ($username_stmt->rowCount() > 0) {
		
		$errorMsg = 'Username already in use. Please try again with different username.';

		echo json_encode($errorMsg);

	} else {
		
		// Insert the user into the table
		$insert_query = "INSERT INTO user (username, email, password, first_name, last_name, date_of_birth) VALUES (:username, :email, :password, :first_name, :last_name, :date_of_birth)";
		$stmt = $db->prepare($insert_query);		
		$stmt->execute(['username' => $username, 'email' => $email, 'password' => $password, 'first_name' => $first_name, 'last_name' => $last_name, 'date_of_birth' => $date_of_birth]);

		// Retrieve the user from the table
		$retrieve_query = "SELECT * FROM user WHERE username = :username";
		$stmt = $db->prepare($retrieve_query);
		$stmt->execute(['username' => $username]);

		$user = $stmt->fetch();

		echo json_encode($user, JSON_NUMERIC_CHECK);

	}

?>