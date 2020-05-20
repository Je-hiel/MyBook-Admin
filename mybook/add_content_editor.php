<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];
	$group_id = $_GET['group_id'];

	$is_member = "SELECT * FROM group_member WHERE user_id = :user_id";

	$stmt = $db->prepare($is_member);
	$stmt->execute(['user_id' => $user_id]);

	if ($stmt->rowCount() > 0) {

		$is_content_editor = "SELECT * FROM content_editor WHERE user_id = :user_id";

		$stmt = $db->prepare($is_content_editor);
		$stmt->execute(['user_id' => $user_id]);

		if ($stmt->rowCount() > 0) {
			$errorMsg = 'User is already a content editor of this group.';
			echo json_encode($errorMsg);
		} else {
			$query = "INSERT INTO content_editor(user_id, group_id) VALUES(:user_id, :group_id)";

			$stmt = $db->prepare($query);
			$stmt->execute(['user_id' => $user_id, 'group_id' => $group_id]);
		}
	} else {
		$errorMsg = 'User is not a member of this group.';
		echo json_encode($errorMsg);
	}

?>