<?php 

	// Gets all the posts created by a specific user
	$user_id = $_GET['user_id'];

	$query = "SELECT * FROM post JOIN post_creator ON post.post_id = post_creator.post_id WHERE post_creator.user_id = :user_id";

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id]);
	$posts = $stmt.fetchAll();

	echo json_encode($posts, JSON_NUMERIC_CHECK);

?>