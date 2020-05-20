<?php 

	// Gets all the groups.

	include('conn.php');

	$query = "SELECT * FROM user_group";

	$stmt = $db->query($query);
	$groups = $stmt->fetchAll();

	echo json_encode($groups, JSON_NUMERIC_CHECK);

?>