<?php 

	// Get whether a user disliked a post or not
	include('conn.php');

	$user_id = $_GET['user_id'];
	$post_id = $_GET['post_id'];

	$query = "SELECT * FROM dislikes JOIN post JOIN disliked_by ON dislikes.post_id = post.post_id AND dislikes.dislike_id = disliked_by.dislike_id WHERE disliked_by.user_id = :user_id AND post.post_id = :post_id";	

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);

	if ($stmt->rowCount() > 0) {
		echo true;
	} else {
		echo false;
	}


?>