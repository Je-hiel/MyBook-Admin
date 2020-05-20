<?php 

	// Gets the content editors for a specific group
	include('conn.php');

	$group_id = $_GET['group_id'];

	$query = "SELECT user.user_id, user.first_name, user.last_name, user.username FROM content_editor JOIN user ON content_editor.user_id = user.user_id WHERE content_editor.group_id = :group_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['group_id' => $group_id]);
	$content_editors = $stmt->fetchAll();

	echo json_encode($content_editors, JSON_NUMERIC_CHECK);

?>