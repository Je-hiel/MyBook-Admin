<?php 

	// Get whether a user liked a post or not
	include('conn.php');

	$user_id = $_GET['user_id'];
	$post_id = $_GET['post_id'];

	$query = "SELECT * FROM likes JOIN post JOIN liked_by ON likes.post_id = post.post_id AND likes.like_id = liked_by.like_id WHERE liked_by.user_id = :user_id AND post.post_id = :post_id";	

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);

	if ($stmt->rowCount() > 0) {
		echo true;
	} else {
		echo false;
	}


?>