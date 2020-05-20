<?php 

	// Gets all the posts a specific user can see -- ie. posts from themselves and posts from friends
	include('conn.php');

	$user_id = $_GET['user_id'];

	$query = "SELECT post.post_id, user.first_name, user.last_name, user.username, post.title, post.content, post.created_at FROM post JOIN post_creator JOIN user ON post.post_id = post_creator.post_id AND post_creator.user_id = user.user_id WHERE user.user_id = :user_id1 UNION SELECT post.post_id, user.first_name, user.last_name, user.username, post.title, post.content, post.created_at FROM post JOIN post_creator JOIN friend JOIN user ON post.post_id = post_creator.post_id AND post_creator.user_id = user.user_id AND post_creator.user_id = friend.friend_id WHERE friend.user_id = :user_id2 GROUP BY post.post_id ORDER BY 7 DESC LIMIT 300";

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id1' => $user_id, 'user_id2' => $user_id]);
	$posts = $stmt->fetchAll();
	
	echo json_encode($posts, JSON_NUMERIC_CHECK);

?>