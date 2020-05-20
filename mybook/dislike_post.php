<?php 


	include('conn.php');

	$user_id = $_GET['user_id'];
	$post_id = $_GET['post_id'];

	// Query to check if the user has already liked this post
	$liked_query = "SELECT likes.like_id FROM likes JOIN post JOIN liked_by JOIN user ON post.post_id = likes.post_id AND likes.like_id = liked_by.like_id AND liked_by.user_id = user.user_id WHERE user.user_id = :user_id AND post.post_id = :post_id";

    $stmt = $db->prepare($liked_query);
	$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);
	$liked = $stmt->fetch();
	
	// If the user did not already like the post
	if ($liked == NULL) {

		// Query to check if the user has already disliked this post
		$disliked_query = "SELECT dislikes.dislike_id FROM dislikes JOIN post JOIN disliked_by JOIN user ON post.post_id = dislikes.post_id AND dislikes.dislike_id = disliked_by.dislike_id AND disliked_by.user_id = user.user_id WHERE user.user_id = :user_id AND post.post_id = :post_id";
		
		$stmt = $db->prepare($disliked_query);
		$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);
		$disliked = $stmt->fetch();
		
		if($disliked == NULL) {
			// Add new dislike
			$new_dislike = "INSERT INTO dislikes(post_id) VALUES (:post_id)";
			$stmt = $db->prepare($new_dislike);
			$stmt->execute(['post_id' => $post_id]);
			
			$last_id = $db->lastInsertId();

			// Add new disliked_by
			$disliked_by = "INSERT INTO disliked_by(dislike_id, user_id) VALUES(:dislike_id, :user_id)";
			$stmt = $db->prepare($disliked_by);
			$stmt->execute(['dislike_id' => $last_id, 'user_id' => $user_id]);
		}

	} else { // If the user already liked the post

		// Delete like from table
		$delete_liked = "DELETE FROM likes WHERE like_id = :like_id";
		$stmt = $db->prepare($delete_liked);
		$stmt->execute(['like_id' => $liked['like_id']]);

		// Add new dislike
		$new_dislike = "INSERT INTO dislikes(post_id) VALUES (:post_id)";
		$stmt = $db->prepare($new_dislike);
		$stmt->execute(['post_id' => $post_id]);
		
		$last_id = $db->lastInsertId();

		// Add new disliked_by
		$disliked_by = "INSERT INTO disliked_by(dislike_id, user_id) VALUES(:dislike_id, :user_id)";
		$stmt = $db->prepare($disliked_by);
		$stmt->execute(['dislike_id' => $last_id, 'user_id' => $user_id]);
	}

?>