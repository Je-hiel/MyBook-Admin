<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];
	$friend_id = $_GET['friend_id'];
	$type = $_GET['type'];

	$already_friends = "SELECT * FROM friend WHERE user_id = :user_id AND friend_id = :friend_id";

	$stmt = $db->prepare($already_friends);
	$stmt->execute(['user_id' => $user_id, 'friend_id' => $friend_id]);

	if ($stmt->rowCount() > 0) {
		$errorMsg = 'Users are already friends.';
		echo json_encode($errorMsg);
	} else {
		$query = "INSERT INTO friend(user_id, friend_id, type) VALUES(:user_id, :friend_id, :type)";

		$stmt = $db->prepare($query);
		$stmt->execute(['user_id' => $user_id, 'friend_id' => $friend_id, 'type' => $type]);
	}

?>