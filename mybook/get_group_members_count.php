<?php 

	// Returns the number of members in a group
	include('conn.php');

	$name = $_GET['name'];

	$query = "SELECT COUNT(*) as count FROM user_group WHERE name = :name";

	$stmt = $db->prepare($query);
	$stmt->execute(['name' => $name]);
	$count = $stmt->fetch();

	echo json_encode($count, JSON_NUMERIC_CHECK);

?>