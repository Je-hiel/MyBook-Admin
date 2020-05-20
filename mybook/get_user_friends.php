<?php 

	// Returns the friends a user has

	include('conn.php');

	$user_id = $_GET['user_id'];

	$query = "SELECT user.user_id, user.first_name, user.last_name, user.username FROM friend JOIN user ON friend.friend_id = user.user_id WHERE friend.user_id = :user_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id]);
	$friends = $stmt.fetchAll();

	echo json_encode($friends, JSON_NUMERIC_CHECK);

?>