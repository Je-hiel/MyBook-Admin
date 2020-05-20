<?php

    include('conn.php');

    $user_id = $_GET['user_id'];
    $group_id = $_GET['group_id'];
    $title = $_GET['title'];
    $body = $_GET['body'];

	$post_query = "INSERT INTO post(title, content) VALUES(:title, :content)";

	$stmt = $db->prepare($post_query);
	$status = $stmt->execute(['title' => $title, 'content' => $body]);


	if ($status) {

		$last_id = $db->lastInsertId(); // Gets the post id of the inserted post

		$creator_query = "INSERT INTO post_creator(post_id, user_id) VALUES(:post_id, :user_id)";

		$stmt = $db->prepare($creator_query);
		$status = $stmt->execute(['post_id' => $last_id, 'user_id' => $user_id]);

		
		if ($status) {

			$add_group_post = "INSERT INTO group_post(post_id, group_id) VALUES(:post_id, :group_id)";

			$stmt = $db->prepare($creator_query);
			$status = $stmt->execute(['post_id' => $last_id, 'group_id' => $group_id]);

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