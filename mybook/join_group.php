<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];
	$group_id = $_GET['group_id'];

	$already_member = "SELECT * FROM group_member WHERE user_id = :user_id AND group_id = :group_id";

	$stmt = $db->prepare($already_member);
	$stmt->execute(['user_id' => $user_id, 'group_id' => $group_id]);

	if ($stmt->rowCount() > 0) {
		$errorMsg = 'User is already in group.';
		echo json_encode($errorMsg);
	} else {
		$query = "INSERT INTO group_member(user_id, group_id) VALUES(:user_id, :group_id)";

		$stmt = $db->prepare($query);
		$stmt->execute(['user_id' => $user_id, 'group_id' => $group_id]);
	}
?>