<?php 

	include('conn.php');

	$user_id = $_GET['user_id'];
	$post_id = $_GET['post_id'];
	$body = $_GET['body'];

	$comment_query = "INSERT INTO comment(post_id, content) VALUES(:post_id, :content)";

	$stmt = $db->prepare($comment_query);
	$status = $stmt->execute(['post_id' => $post_id, 'content' => $body]);


	if ($status) {

		$last_id = $db->lastInsertId(); // Gets the comment id of the inserted comment

		$commenter_query = "INSERT INTO commenter(comment_id, user_id) VALUES (:comment_id, :user_id)";

		$stmt = $db->prepare($commenter_query);
		$status = $stmt->execute(['comment_id' => $last_id, 'user_id' => $user_id]);

		if ($status) {
			echo true;
		} else {

			$errorMsg = 'Something went wrong. Please try again later.';
			echo json_encode($errorMsg);

		}

	} else {

		$errorMsg = 'Something went wrong. Please try again later.';
		echo json_encode($errorMsg);

	}

?>