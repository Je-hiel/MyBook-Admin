<?php 

	// Returns all the members of a group
	include('conn.php');

	$user_id = $_GET['user_id'];
	$group_id = $_GET['group_id'];

	$query = "SELECT user.user_id, user.first_name, user.last_name, user.username FROM group_member JOIN user ON group_member.user_id = user.user_id WHERE group_id = :group_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['group_id' => $group_id]);
	$members = $stmt.fetchAll();

	echo json_encode($members, JSON_NUMERIC_CHECK);

?>