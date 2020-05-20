<?php 

	include('conn.php');

	$username = $_GET['username'];
	$password = $_GET['password'];

	$query = "SELECT * FROM user WHERE username = :username AND password = :password";

	$stmt = $db->prepare($query);
	$stmt->execute(['username' => $username, 'password' => $password]);
	$user = $stmt->fetch();

	echo json_encode($user, JSON_NUMERIC_CHECK);

?>