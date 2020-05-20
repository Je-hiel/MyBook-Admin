<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];

	$query = 'SELECT * FROM user WHERE user_id = :user_id';

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id]);
	$user = $stmt->fetch();

	echo json_encode($user, JSON_NUMERIC_CHECK);

?>