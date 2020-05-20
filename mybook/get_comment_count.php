<?php 

	include('conn.php');

	$post_id = $_GET['post_id'];

	$query = "SELECT COUNT(*) as count FROM post JOIN comment ON post.post_id = comment.post_id WHERE post.post_id = :post_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['post_id' => $post_id]);
	$count = $stmt->fetch();

	echo json_encode($count, JSON_NUMERIC_CHECK);

?>