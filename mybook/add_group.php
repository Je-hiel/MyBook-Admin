<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];
	$name = $_GET['name'];

	$name_check = "SELECT * FROM user_group WHERE name = :name";

	$stmt = $db->prepare($name_check);
	$stmt->execute(['name' => $name]);

	if ($stmt->rowCount() > 0) {
		$errorMsg = 'Group name already in use. Please select a different name.';
		echo json_encode($errorMsg);
	} else {
		$add_group = "INSERT INTO user_group(name) VALUES(:name)";

		$stmt = $db->prepare($add_group);
		$stmt->execute(['name' => $name]);

		$last_id = $db->lastInsertId();

		$add_group_creator = "INSERT INTO group_creator(group_id, user_id) VALUES(:group_id, :user_id)";

		$stmt = $db->prepare($add_group_creator);
		$stmt->execute(['group_id' => $last_id, 'user_id' => $user_id]);

	}

?>