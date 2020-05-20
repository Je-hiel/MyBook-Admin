<?php 

	include('conn.php');

	// Returns the groups a user is in
	$user_id = $_GET['user_id'];

	$query = "SELECT user_group.group_id, user_group.name FROM group_member JOIN user_group ON group_member.group_id = user_group.group_id WHERE group_member.user_id = :user_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id]);
	$groups = $stmt->fetchAll();

	echo json_encode($groups, JSON_NUMERIC_CHECK);

?>