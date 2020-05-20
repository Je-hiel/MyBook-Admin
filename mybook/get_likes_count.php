<?php 

	include('conn.php');

	$post_id = $_GET['post_id'];

	$query = "SELECT COUNT(*) as count FROM likes WHERE post_id = :post_id";


	$stmt = $db->prepare($query);
	$stmt->execute(['post_id' => $post_id]);
	$count = $stmt->fetch();

	echo json_encode($count, JSON_NUMERIC_CHECK);

?>