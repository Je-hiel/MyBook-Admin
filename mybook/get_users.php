<?php

    include('conn.php');

	$query = 'SELECT * FROM user';

	$stmt = $db->query($query);
	$users = $stmt->fetchAll();

	echo json_encode($users, JSON_NUMERIC_CHECK);

?>