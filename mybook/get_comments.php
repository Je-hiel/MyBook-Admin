<?php 

	// Getting the comments on one specific post.

	include('conn.php');

	$post_id = $_GET['post_id'];

	$query = "SELECT comment.comment_id, user.first_name, user.last_name, user.username, comment.content, comment.created_at FROM comment JOIN commenter JOIN user ON comment.comment_id = commenter.comment_id AND commenter.user_id = user.user_id WHERE post_id = :post_id ORDER BY created_at";

	$stmt = $db->prepare($query);
	$stmt->execute(['post_id' => $post_id]);
	$comments = $stmt->fetchAll();

	echo json_encode($comments, JSON_NUMERIC_CHECK);

?>